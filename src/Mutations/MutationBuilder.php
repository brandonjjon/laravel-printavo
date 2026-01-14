<?php

namespace Brandonjjon\Printavo\Mutations;

use Brandonjjon\Printavo\Contracts\Mutable;
use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\PrintavoClient;

abstract class MutationBuilder implements Mutable
{
    /**
     * The singular resource name (e.g., 'contact').
     */
    protected string $resource;

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<BaseData>
     */
    protected string $dataClass;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];

    /**
     * The collected input data for the mutation.
     *
     * @var array<string, mixed>
     */
    protected array $input = [];

    /**
     * Create a new mutation builder instance.
     */
    public function __construct(
        protected readonly PrintavoClient $client,
    ) {}

    /**
     * Set a single input field value.
     */
    public function set(string $field, mixed $value): static
    {
        $clone = clone $this;
        $clone->input[$field] = $value;

        return $clone;
    }

    /**
     * Set multiple input field values.
     *
     * @param  array<string, mixed>  $data
     */
    public function fill(array $data): static
    {
        $clone = clone $this;
        $clone->input = array_merge($clone->input, $data);

        return $clone;
    }

    /**
     * Execute a create mutation with the current input.
     */
    public function create(): MutationResponse
    {
        $mutation = $this->toGraphQL('create');
        $variables = ['input' => $this->buildInput()];

        $mutationName = 'create'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return MutationResponse::fromArray(
            response: $result[$mutationName] ?? [],
            resourceKey: $this->resource,
            dataClass: $this->dataClass,
        );
    }

    /**
     * Execute an update mutation for the given resource ID.
     */
    public function update(string $id): MutationResponse
    {
        $mutation = $this->toGraphQL('update');
        $input = $this->buildInput();
        $input['id'] = $id;
        $variables = ['input' => $input];

        $mutationName = 'update'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return MutationResponse::fromArray(
            response: $result[$mutationName] ?? [],
            resourceKey: $this->resource,
            dataClass: $this->dataClass,
        );
    }

    /**
     * Execute a delete mutation for the given resource ID.
     */
    public function delete(string $id): MutationResponse
    {
        $mutation = $this->toDeleteGraphQL();
        $variables = ['input' => ['id' => $id]];

        $mutationName = 'delete'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return MutationResponse::forDelete($result[$mutationName] ?? []);
    }

    /**
     * Execute a bulk create mutation.
     *
     * @param  array<int, array<string, mixed>>  $items  Array of input data for each item
     * @return array<int, MutationResponse>
     */
    public function createMany(array $items): array
    {
        $mutation = $this->toBulkGraphQL('creates');
        $variables = ['input' => $this->buildBulkInput($items)];

        $mutationName = 'creates'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return $this->parseBulkResponse($result[$mutationName] ?? []);
    }

    /**
     * Execute a bulk update mutation.
     *
     * @param  array<int, array<string, mixed>>  $items  Array of input data with 'id' key for each item
     * @return array<int, MutationResponse>
     */
    public function updateMany(array $items): array
    {
        $mutation = $this->toBulkGraphQL('updates');
        $variables = ['input' => $items];

        $mutationName = 'updates'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return $this->parseBulkResponse($result[$mutationName] ?? []);
    }

    /**
     * Execute a bulk delete mutation.
     *
     * @param  array<int, string>  $ids  Array of resource IDs to delete
     * @return array<int, MutationResponse>
     */
    public function deleteMany(array $ids): array
    {
        $mutation = $this->toBulkDeleteGraphQL();
        $input = array_map(fn (string $id): array => ['id' => $id], $ids);
        $variables = ['input' => $input];

        $mutationName = 'deletes'.ucfirst($this->resource);
        $result = $this->client->mutate($mutation, $variables);

        return $this->parseBulkDeleteResponse($result[$mutationName] ?? [], count($ids));
    }

    /**
     * Build the input array for the mutation.
     *
     * @return array<string, mixed>
     */
    protected function buildInput(): array
    {
        return $this->input;
    }

    /**
     * Build the input array for bulk mutations.
     *
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    protected function buildBulkInput(array $items): array
    {
        return $items;
    }

    /**
     * Parse bulk mutation response into array of MutationResponses.
     *
     * @param  array<string, mixed>  $response
     * @return array<int, MutationResponse>
     */
    protected function parseBulkResponse(array $response): array
    {
        $pluralKey = $this->getPluralResource();
        $items = $response[$pluralKey] ?? [];
        $errors = $response['errors'] ?? null;

        $responses = [];
        foreach ($items as $item) {
            $responses[] = MutationResponse::fromArray(
                response: [$this->resource => $item, 'errors' => null],
                resourceKey: $this->resource,
                dataClass: $this->dataClass,
            );
        }

        // If there are errors but no items, create error responses
        if (empty($items) && ! empty($errors)) {
            $responses[] = new MutationResponse(
                success: false,
                data: null,
                errors: $errors,
            );
        }

        return $responses;
    }

    /**
     * Parse bulk delete mutation response into array of MutationResponses.
     *
     * @param  array<string, mixed>  $response
     * @return array<int, MutationResponse>
     */
    protected function parseBulkDeleteResponse(array $response, int $expectedCount): array
    {
        $errors = $response['errors'] ?? null;
        $hasErrors = ! empty($errors);

        $responses = [];
        for ($i = 0; $i < $expectedCount; $i++) {
            $responses[] = new MutationResponse(
                success: ! $hasErrors,
                data: null,
                errors: $hasErrors && $i === 0 ? $errors : null,
            );
        }

        return $responses;
    }

    /**
     * Get the plural form of the resource name.
     */
    protected function getPluralResource(): string
    {
        // Simple pluralization - override in subclass for irregular plurals
        return $this->resource.'s';
    }

    /**
     * Generate the GraphQL mutation string.
     */
    protected function toGraphQL(string $operation): string
    {
        $mutationName = $operation.ucfirst($this->resource);
        $inputType = ucfirst($operation).ucfirst($this->resource).'Input!';
        $fields = $this->buildFieldSelection();

        $mutation = "mutation {$mutationName}(\$input: {$inputType}) {\n";
        $mutation .= "  {$mutationName}(input: \$input) {\n";
        $mutation .= "    {$this->resource} {\n";
        $mutation .= $this->indentFields($fields, 6);
        $mutation .= "    }\n";
        $mutation .= "    errors {\n";
        $mutation .= "      field\n";
        $mutation .= "      message\n";
        $mutation .= "    }\n";
        $mutation .= "  }\n";
        $mutation .= '}';

        return $mutation;
    }

    /**
     * Generate the GraphQL mutation string for delete operations.
     */
    protected function toDeleteGraphQL(): string
    {
        $mutationName = 'delete'.ucfirst($this->resource);
        $inputType = 'Delete'.ucfirst($this->resource).'Input!';

        $mutation = "mutation {$mutationName}(\$input: {$inputType}) {\n";
        $mutation .= "  {$mutationName}(input: \$input) {\n";
        $mutation .= "    errors {\n";
        $mutation .= "      field\n";
        $mutation .= "      message\n";
        $mutation .= "    }\n";
        $mutation .= "  }\n";
        $mutation .= '}';

        return $mutation;
    }

    /**
     * Generate the GraphQL mutation string for bulk operations.
     */
    protected function toBulkGraphQL(string $operation): string
    {
        $mutationName = $operation.ucfirst($this->resource);
        $singularInputType = ucfirst(rtrim($operation, 's')).ucfirst($this->resource).'Input!';
        $inputType = "[{$singularInputType}]!";
        $fields = $this->buildFieldSelection();
        $pluralKey = $this->getPluralResource();

        $mutation = "mutation {$mutationName}(\$input: {$inputType}) {\n";
        $mutation .= "  {$mutationName}(input: \$input) {\n";
        $mutation .= "    {$pluralKey} {\n";
        $mutation .= $this->indentFields($fields, 6);
        $mutation .= "    }\n";
        $mutation .= "    errors {\n";
        $mutation .= "      field\n";
        $mutation .= "      message\n";
        $mutation .= "    }\n";
        $mutation .= "  }\n";
        $mutation .= '}';

        return $mutation;
    }

    /**
     * Generate the GraphQL mutation string for bulk delete operations.
     */
    protected function toBulkDeleteGraphQL(): string
    {
        $mutationName = 'deletes'.ucfirst($this->resource);
        $singularInputType = 'Delete'.ucfirst($this->resource).'Input!';
        $inputType = "[{$singularInputType}]!";

        $mutation = "mutation {$mutationName}(\$input: {$inputType}) {\n";
        $mutation .= "  {$mutationName}(input: \$input) {\n";
        $mutation .= "    errors {\n";
        $mutation .= "      field\n";
        $mutation .= "      message\n";
        $mutation .= "    }\n";
        $mutation .= "  }\n";
        $mutation .= '}';

        return $mutation;
    }

    /**
     * Build the field selection string.
     */
    protected function buildFieldSelection(): string
    {
        return implode("\n", $this->defaultFields);
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
}
