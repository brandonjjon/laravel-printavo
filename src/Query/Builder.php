<?php

namespace Brandonjjon\Printavo\Query;

use Brandonjjon\Printavo\Contracts\Queryable;
use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\PrintavoClient;
use Illuminate\Support\Collection;

abstract class Builder implements Queryable
{
    /**
     * The GraphQL query name for collections (e.g., 'customers').
     */
    protected string $resource;

    /**
     * The GraphQL query name for single items (e.g., 'customer').
     */
    protected string $singularResource;

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<BaseData>
     */
    protected string $dataClass;

    /**
     * The where conditions for the query.
     *
     * @var array<string, mixed>
     */
    protected array $wheres = [];

    /**
     * The GraphQL types for where conditions (when explicitly set).
     *
     * @var array<string, string>
     */
    protected array $whereTypes = [];

    /**
     * The fields to select.
     *
     * @var array<string>
     */
    protected array $selects = ['id'];

    /**
     * The limit for results.
     */
    protected ?int $limit = null;

    /**
     * The cursor for pagination.
     */
    protected ?string $cursor = null;

    /**
     * Whether this is a paginated query.
     */
    protected bool $isPaginated = false;

    /**
     * Create a new builder instance.
     */
    public function __construct(
        protected readonly PrintavoClient $client,
    ) {}

    /**
     * Add a where condition to the query.
     */
    public function where(string $field, mixed $value): static
    {
        $clone = clone $this;
        $clone->wheres[$field] = $value;

        return $clone;
    }

    /**
     * Add a where condition with an explicit GraphQL type.
     *
     * Used by generated typed filter methods to ensure correct GraphQL types.
     */
    protected function whereTyped(string $field, mixed $value, string $graphqlType): static
    {
        $clone = clone $this;
        $clone->wheres[$field] = $value;
        $clone->whereTypes[$field] = $graphqlType;

        return $clone;
    }

    /**
     * Format a date value for the GraphQL API.
     */
    protected function formatDate(string|\DateTimeInterface $date): string
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format('c'); // ISO 8601 format
        }

        return $date;
    }

    /**
     * Specify fields to select from the query.
     *
     * @param  array<string>|string  $fields
     */
    public function select(array|string $fields): static
    {
        $clone = clone $this;
        $fields = is_array($fields) ? $fields : [$fields];

        // Ensure 'id' is always included
        if (! in_array('id', $fields)) {
            array_unshift($fields, 'id');
        }

        $clone->selects = $fields;

        return $clone;
    }

    /**
     * Limit the number of results.
     */
    public function take(int $count): static
    {
        $clone = clone $this;
        $clone->limit = $count;

        return $clone;
    }

    /**
     * Set the cursor for pagination.
     */
    public function cursor(string $cursor): static
    {
        $clone = clone $this;
        $clone->cursor = $cursor;

        return $clone;
    }

    /**
     * Get the first result matching the query.
     */
    public function first(): ?BaseData
    {
        $builder = $this->take(1);
        $builder->isPaginated = false;

        $result = $builder->executeQuery();

        if (empty($result)) {
            return null;
        }

        $nodes = $this->extractNodes($result);

        if (empty($nodes)) {
            return null;
        }

        return $this->dataClass::fromArray($nodes[0]);
    }

    /**
     * Find a record by its ID.
     */
    public function find(string $id): ?BaseData
    {
        $query = $this->buildSingularQuery($id);
        $variables = ['id' => $id];

        $result = $this->client->query($query, $variables);

        if (empty($result[$this->singularResource])) {
            return null;
        }

        return $this->dataClass::fromArray($result[$this->singularResource]);
    }

    /**
     * Get all results matching the query.
     *
     * @return Collection<int, BaseData>
     */
    public function get(): Collection
    {
        $this->isPaginated = false;
        $result = $this->executeQuery();

        if (empty($result)) {
            return collect();
        }

        $nodes = $this->extractNodes($result);

        return collect($this->dataClass::collection($nodes));
    }

    /**
     * Paginate results with cursor-based pagination.
     */
    public function paginate(int $perPage = 25): Paginator
    {
        $builder = clone $this;
        $builder->limit = $perPage;
        $builder->isPaginated = true;

        $result = $builder->executeQuery();

        if (empty($result)) {
            return new Paginator([], null, false, $perPage);
        }

        $nodes = $this->extractNodes($result);
        $pageInfo = $this->extractPageInfo($result);

        $items = $this->dataClass::collection($nodes);
        $nextCursor = $pageInfo['endCursor'] ?? null;
        $hasMorePages = $pageInfo['hasNextPage'] ?? false;

        return new Paginator($items, $nextCursor, $hasMorePages, $perPage);
    }

    /**
     * Execute the query and return raw results.
     *
     * @return array<string, mixed>
     */
    protected function executeQuery(): array
    {
        $query = $this->toGraphQL();
        $variables = $this->buildVariables();

        $result = $this->client->query($query, $variables);

        return $result[$this->resource] ?? [];
    }

    /**
     * Build the GraphQL query string.
     */
    protected function toGraphQL(): string
    {
        $variableDefinitions = $this->buildVariableDefinitions();
        $arguments = $this->buildArguments();
        $fields = $this->buildFieldSelection();

        $query = 'query';

        if (! empty($variableDefinitions)) {
            $query .= "({$variableDefinitions})";
        }

        $query .= " {\n";
        $query .= "  {$this->resource}";

        if (! empty($arguments)) {
            $query .= "({$arguments})";
        }

        $query .= " {\n";

        if ($this->isPaginated) {
            $query .= "    pageInfo {\n";
            $query .= "      hasNextPage\n";
            $query .= "      endCursor\n";
            $query .= "    }\n";
            $query .= "    nodes {\n";
            $query .= $this->indentFields($fields, 6);
            $query .= "    }\n";
        } else {
            $query .= "    nodes {\n";
            $query .= $this->indentFields($fields, 6);
            $query .= "    }\n";
        }

        $query .= "  }\n";
        $query .= '}';

        return $query;
    }

    /**
     * Build the singular query for find().
     */
    protected function buildSingularQuery(string $id): string
    {
        $fields = $this->buildFieldSelection();

        $query = "query(\$id: ID!) {\n";
        $query .= "  {$this->singularResource}(id: \$id) {\n";
        $query .= $this->indentFields($fields, 4);
        $query .= "  }\n";
        $query .= '}';

        return $query;
    }

    /**
     * Build variable definitions for the query.
     */
    protected function buildVariableDefinitions(): string
    {
        $definitions = [];

        foreach ($this->wheres as $field => $value) {
            // Use explicit type if set, otherwise infer from value
            $type = $this->whereTypes[$field] ?? $this->inferGraphQLType($value);
            $definitions[] = "\${$field}: {$type}";
        }

        if ($this->cursor !== null) {
            $definitions[] = '$after: String';
        }

        return implode(', ', $definitions);
    }

    /**
     * Build the arguments string for the query.
     */
    protected function buildArguments(): string
    {
        $args = [];

        if ($this->limit !== null) {
            $args[] = "first: {$this->limit}";
        }

        if ($this->cursor !== null) {
            $args[] = 'after: $after';
        }

        foreach (array_keys($this->wheres) as $field) {
            $args[] = "{$field}: \${$field}";
        }

        return implode(', ', $args);
    }

    /**
     * Build the variables array for the query.
     *
     * @return array<string, mixed>
     */
    protected function buildVariables(): array
    {
        $variables = $this->wheres;

        if ($this->cursor !== null) {
            $variables['after'] = $this->cursor;
        }

        return $variables;
    }

    /**
     * Build the field selection string.
     */
    protected function buildFieldSelection(): string
    {
        $fields = [];

        foreach ($this->selects as $field) {
            if (str_contains($field, '.')) {
                // Handle nested fields (e.g., customer.email)
                $fields[] = $this->buildNestedField($field);
            } else {
                $fields[] = $field;
            }
        }

        return implode("\n", $fields);
    }

    /**
     * Build a nested field selection from dot notation.
     */
    protected function buildNestedField(string $dotNotation): string
    {
        $parts = explode('.', $dotNotation);
        $result = array_pop($parts);

        foreach (array_reverse($parts) as $part) {
            $result = "{$part} {\n  {$result}\n}";
        }

        return $result;
    }

    /**
     * Indent fields with the specified number of spaces.
     */
    protected function indentFields(string $fields, int $spaces): string
    {
        $indent = str_repeat(' ', $spaces);
        $lines = explode("\n", $fields);

        return implode("\n", array_map(fn ($line) => $indent.$line, $lines))."\n";
    }

    /**
     * Infer the GraphQL type from a PHP value.
     */
    protected function inferGraphQLType(mixed $value): string
    {
        return match (true) {
            is_int($value) => 'Int',
            is_float($value) => 'Float',
            is_bool($value) => 'Boolean',
            default => 'String',
        };
    }

    /**
     * Extract nodes from the query result.
     *
     * @param  array<string, mixed>  $result
     * @return array<int, array<string, mixed>>
     */
    protected function extractNodes(array $result): array
    {
        return $result['nodes'] ?? [];
    }

    /**
     * Extract page info from the query result.
     *
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    protected function extractPageInfo(array $result): array
    {
        return $result['pageInfo'] ?? [];
    }
}
