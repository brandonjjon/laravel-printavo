<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates PHP query builder classes from GraphQL Query fields.
 *
 * This generator creates resource-specific builders (like CustomersBuilder)
 * from GraphQL schema Query type fields that return Connection types.
 */
readonly class QueryBuilderGenerator
{
    /**
     * Irregular plural to singular mappings.
     *
     * @var array<string, string>
     */
    private const IRREGULAR_PLURALS = [
        'inquiries' => 'inquiry',
        'statuses' => 'status',
        'categories' => 'category',
        'deliveries' => 'delivery',
        'companies' => 'company',
        'addresses' => 'address',
        'taxes' => 'tax',
    ];

    /**
     * Pagination arguments to skip when generating filter methods.
     *
     * @var array<string>
     */
    private const PAGINATION_ARGS = ['first', 'last', 'after', 'before'];

    public function __construct(
        private TypeMapper $typeMapper,
    ) {}

    /**
     * Check if this Query field should have a builder generated.
     *
     * Returns true only for collection queries that return Connection types.
     * Skips singular queries, singletons, and mutations.
     */
    public function shouldGenerate(FieldDefinition $field, ParsedSchema $schema): bool
    {
        // Only generate for fields that return Connection types
        if (! str_ends_with($field->type, 'Connection')) {
            return false;
        }

        // Skip 'account' query - it's a singleton
        if ($field->name === 'account') {
            return false;
        }

        // Skip login/logout or other auth-related queries
        if (in_array($field->name, ['login', 'logout', 'authenticate'], true)) {
            return false;
        }

        return true;
    }

    /**
     * Generate the PHP builder class code for a Query field.
     */
    public function generate(FieldDefinition $field, ParsedSchema $schema): string
    {
        $className = $this->getClassName($field);
        $resource = $field->name;
        $singularResource = $this->getSingularResource($resource);
        $returnTypeName = $this->getReturnTypeName($field, $schema);
        $dataClass = $this->getDataClassName($returnTypeName);

        $filterArgs = $this->getFilterArguments($field);
        $imports = $this->generateImports($filterArgs, $returnTypeName);
        $filterMethods = $this->generateFilterMethods($filterArgs);

        return <<<PHP
<?php

namespace Brandonjjon\Printavo\Resources\Generated;

{$imports}
/**
 * Query builder for {$resource} collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class {$className} extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string \$resource = '{$resource}';

    /**
     * The GraphQL query name for single items.
     */
    protected string \$singularResource = '{$singularResource}';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<{$returnTypeName}>
     */
    protected string \$dataClass = {$returnTypeName}::class;

    /**
     * The fields to select.
     *
     * @var array<string>
     */
    protected array \$selects = [];

    /**
     * Create a new builder instance.
     */
    public function __construct(PrintavoClient \$client)
    {
        parent::__construct(\$client);
        \$this->selects = {$returnTypeName}::defaultFields();
    }
{$filterMethods}}
PHP;
    }

    /**
     * Get filter arguments (excluding pagination args).
     *
     * @return array<string, ArgumentDefinition>
     */
    private function getFilterArguments(FieldDefinition $field): array
    {
        $filterArgs = [];

        foreach ($field->args as $arg) {
            if (! in_array($arg->name, self::PAGINATION_ARGS, true)) {
                $filterArgs[$arg->name] = $arg;
            }
        }

        return $filterArgs;
    }

    /**
     * Generate import statements for the builder.
     *
     * @param  array<string, ArgumentDefinition>  $filterArgs
     */
    private function generateImports(array $filterArgs, string $returnTypeName): string
    {
        $imports = [
            "use Brandonjjon\\Printavo\\Data\\Generated\\{$returnTypeName};",
            'use Brandonjjon\\Printavo\\PrintavoClient;',
            'use Brandonjjon\\Printavo\\Query\\Builder;',
        ];

        // Collect enum imports
        $enumImports = [];
        foreach ($filterArgs as $arg) {
            if ($this->typeMapper->isEnum($arg->type)) {
                $enumImports[] = "use Brandonjjon\\Printavo\\Data\\Generated\\Enums\\{$arg->type};";
            }
        }

        // Sort and dedupe enum imports
        $enumImports = array_unique($enumImports);
        sort($enumImports);

        return implode("\n", array_merge($imports, $enumImports))."\n";
    }

    /**
     * Generate typed filter methods for all arguments.
     *
     * @param  array<string, ArgumentDefinition>  $filterArgs
     */
    private function generateFilterMethods(array $filterArgs): string
    {
        if (empty($filterArgs)) {
            return '';
        }

        $methods = [];

        foreach ($filterArgs as $arg) {
            $methods[] = $this->generateFilterMethod($arg);
        }

        return "\n".implode("\n", $methods);
    }

    /**
     * Generate a single typed filter method.
     */
    private function generateFilterMethod(ArgumentDefinition $arg): string
    {
        $methodName = $arg->name;
        $graphqlType = $arg->type;
        $description = $arg->description ?? "Filter by {$arg->name}";

        // Determine PHP type and value handling
        [$phpType, $valueExpr] = $this->getPhpTypeAndValue($arg);

        // Handle list types
        if ($arg->isList) {
            $graphqlType = "[{$graphqlType}!]";
        }

        return <<<PHP

    /**
     * {$description}
     */
    public function {$methodName}({$phpType} \$value): static
    {
        return \$this->whereTyped('{$arg->name}', {$valueExpr}, '{$graphqlType}');
    }
PHP;
    }

    /**
     * Get PHP type hint and value expression for an argument.
     *
     * @return array{0: string, 1: string}
     */
    private function getPhpTypeAndValue(ArgumentDefinition $arg): array
    {
        $type = $arg->type;

        // Handle enums
        if ($this->typeMapper->isEnum($type)) {
            if ($arg->isList) {
                return ['array', 'array_map(fn ($v) => $v->value, $value)'];
            }

            return [$type, '$value->value'];
        }

        // Handle date types
        if ($type === 'ISO8601DateTime' || $type === 'ISO8601Date') {
            return ['string|\DateTimeInterface', '$this->formatDate($value)'];
        }

        // Handle scalar types
        $phpType = match ($type) {
            'ID', 'String' => 'string',
            'Int' => 'int',
            'Float' => 'float',
            'Boolean' => 'bool',
            default => 'mixed',
        };

        if ($arg->isList) {
            return ['array', '$value'];
        }

        return [$phpType, '$value'];
    }

    /**
     * Get the class name for the builder.
     *
     * Converts the field name to PascalCase and appends 'Builder'.
     * Example: 'customers' -> 'CustomersBuilder'
     */
    public function getClassName(FieldDefinition $field): string
    {
        $name = ucfirst($field->name);

        return $name.'Builder';
    }

    /**
     * Convert a plural resource name to its singular form.
     *
     * Handles irregular plurals like 'inquiries' -> 'inquiry'.
     * Example: 'customers' -> 'customer'
     */
    public function getSingularResource(string $resource): string
    {
        // Check irregular plurals first
        if (isset(self::IRREGULAR_PLURALS[$resource])) {
            return self::IRREGULAR_PLURALS[$resource];
        }

        // Handle regular plurals ending in 's'
        if (str_ends_with($resource, 's') && ! str_ends_with($resource, 'ss')) {
            return substr($resource, 0, -1);
        }

        return $resource;
    }

    /**
     * Extract the return type name from a Connection type.
     *
     * Unwraps Connection and Union suffixes to get the base type.
     * Example: 'CustomerConnection' -> 'Customer'
     * Example: 'OrderUnionConnection' -> 'Order'
     */
    public function getReturnTypeName(FieldDefinition $field, ParsedSchema $schema): string
    {
        $typeName = $field->type;

        // Remove 'Connection' suffix
        if (str_ends_with($typeName, 'Connection')) {
            $typeName = substr($typeName, 0, -10);
        }

        // Remove 'Union' suffix if present (e.g., 'OrderUnion' -> 'Order')
        if (str_ends_with($typeName, 'Union')) {
            $typeName = substr($typeName, 0, -5);
        }

        // Handle plural type names (e.g., 'Customers' -> 'Customer')
        // Some schemas might use plural type names
        if (str_ends_with($typeName, 's') && ! $schema->getType($typeName)) {
            $singularType = substr($typeName, 0, -1);
            if ($schema->getType($singularType)) {
                return $singularType;
            }
        }

        return $typeName;
    }

    /**
     * Get the fully qualified data class name for the return type.
     */
    private function getDataClassName(string $typeName): string
    {
        return $typeName;
    }
}
