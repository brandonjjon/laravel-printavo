<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates PHP MutationBuilder subclasses from GraphQL Mutation type.
 */
readonly class MutationBuilderGenerator
{
    /**
     * Mutation patterns that indicate resource operations.
     *
     * Format: {resource}{Operation} -> e.g., contactCreate, contactUpdate
     *
     * @var array<string>
     */
    private const OPERATIONS = [
        'Create',
        'Update',
        'Delete',
    ];

    /**
     * Bulk operation patterns.
     *
     * @var array<string>
     */
    private const BULK_OPERATIONS = [
        'Creates',
        'Updates',
        'Deletes',
    ];

    /**
     * Mutations to skip (not resource-based mutations).
     *
     * @var array<string>
     */
    private const SKIP_MUTATIONS = [
        'login',
        'logout',
    ];

    public function __construct(
        private TypeMapper $typeMapper,
    ) {}

    /**
     * Check if a resource should have a MutationBuilder generated.
     *
     * Returns true if the resource has at least one mutation (create, update, or delete).
     */
    public function shouldGenerate(string $resource, ParsedSchema $schema): bool
    {
        foreach (self::OPERATIONS as $operation) {
            if ($this->hasOperation($resource, $operation, $schema)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all resources that have mutations in the schema.
     *
     * Scans Mutation type fields for {resource}Create, {resource}Update, {resource}Delete patterns.
     *
     * @return array<string> Lowercase resource names (e.g., ['contact', 'customer', 'invoice'])
     */
    public function getResourcesWithMutations(ParsedSchema $schema): array
    {
        $mutationType = $schema->getMutationType();
        if ($mutationType === null) {
            return [];
        }

        $resources = [];
        foreach ($mutationType->fields as $fieldName => $field) {
            // Skip non-resource mutations
            if (in_array($fieldName, self::SKIP_MUTATIONS, true)) {
                continue;
            }

            // Extract resource name from mutation field
            $resource = $this->extractResourceFromMutation($fieldName);
            if ($resource !== null) {
                $resources[$resource] = true;
            }
        }

        return array_keys($resources);
    }

    /**
     * Check if a resource has a specific operation mutation.
     */
    public function hasOperation(string $resource, string $operation, ParsedSchema $schema): bool
    {
        $mutationType = $schema->getMutationType();
        if ($mutationType === null) {
            return false;
        }

        $mutationName = $resource.$operation;

        return isset($mutationType->fields[$mutationName]);
    }

    /**
     * Generate the PHP class code for a resource's MutationBuilder.
     */
    public function generate(string $resource, ParsedSchema $schema): string
    {
        $className = $this->getClassName($resource);
        $resourceUcfirst = $this->ucfirstResource($resource);
        $dataClass = "\\Brandonjjon\\Printavo\\Data\\Generated\\{$resourceUcfirst}";

        return <<<PHP
<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\\{$resourceUcfirst};
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for {$resourceUcfirst} resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class {$className} extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string \$resource = '{$resource}';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<{$resourceUcfirst}>
     */
    protected string \$dataClass = {$resourceUcfirst}::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array \$defaultFields = ['id'];
}
PHP;
    }

    /**
     * Get the class name for a resource's MutationBuilder.
     *
     * @example 'contact' -> 'ContactMutations'
     */
    public function getClassName(string $resource): string
    {
        return $this->ucfirstResource($resource).'Mutations';
    }

    /**
     * Convert a resource name to uppercase first character.
     *
     * @example 'contact' -> 'Contact'
     */
    public function ucfirstResource(string $resource): string
    {
        return ucfirst($resource);
    }

    /**
     * Extract the resource name from a mutation field name.
     *
     * @example 'contactCreate' -> 'contact'
     * @example 'invoiceUpdate' -> 'invoice'
     *
     * @return string|null The resource name or null if not a recognized mutation pattern
     */
    private function extractResourceFromMutation(string $fieldName): ?string
    {
        // Check for singular operations
        foreach (self::OPERATIONS as $operation) {
            if (str_ends_with($fieldName, $operation)) {
                $resource = substr($fieldName, 0, -strlen($operation));
                if (! empty($resource)) {
                    return $resource;
                }
            }
        }

        // Check for bulk operations
        foreach (self::BULK_OPERATIONS as $operation) {
            if (str_ends_with($fieldName, $operation)) {
                $resource = substr($fieldName, 0, -strlen($operation));
                if (! empty($resource)) {
                    return $resource;
                }
            }
        }

        return null;
    }
}
