<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates PHP field constant classes from GraphQL type definitions.
 *
 * Creates type-safe constants for field selection with IDE autocomplete support.
 */
readonly class FieldConstantsGenerator
{
    public function __construct(
        private TypeMapper $typeMapper,
    ) {}

    /**
     * Generate complete PHP class code from a type definition.
     */
    public function generate(TypeDefinition $type, string $safeClassName): string
    {
        $fields = $type->isInput() ? $type->inputFields : $type->fields;
        $constants = $this->generateConstants($fields);
        $description = $type->description ? " * {$type->description}\n *\n" : '';

        return <<<PHP
<?php

namespace Brandonjjon\Printavo\Data\Generated\Fields;

/**
{$description} * Field constants for {$type->name}.
 *
 * @generated from GraphQL schema - do not edit manually
 */
final class {$safeClassName}Fields
{
{$constants}
}
PHP;
    }

    /**
     * Check if this type should have field constants generated.
     */
    public function shouldGenerate(TypeDefinition $type): bool
    {
        return $this->typeMapper->isGeneratableType($type);
    }

    /**
     * Generate constants for all fields.
     *
     * @param  array<string, FieldDefinition>  $fields
     */
    private function generateConstants(array $fields): string
    {
        $constants = [];

        foreach ($fields as $field) {
            if ($this->typeMapper->isConnectionType($field->type)) {
                continue;
            }

            $value = $this->getFieldValue($field);

            if ($value !== null) {
                $constantName = $this->toScreamingSnakeCase($field->name);
                $constants[] = "    public const {$constantName} = '{$value}';";
            }
        }

        return implode("\n", $constants);
    }

    /**
     * Get the field value for a constant.
     *
     * - Scalar fields: just the field name
     * - Enum fields: just the field name (no subselection)
     * - ObjectTimestamps: field name with `{ createdAt updatedAt }` subselection
     * - Nested objects with 'id': field name with `{ id }` subselection
     * - Nested objects without 'id': returns null (skip these)
     */
    private function getFieldValue(FieldDefinition $field): ?string
    {
        $type = $field->type;

        // Scalar and enum fields - just the field name
        if ($this->typeMapper->isScalar($type) || $this->typeMapper->isEnum($type)) {
            return $field->name;
        }

        // Handle timestamp fields with common subfields
        if ($type === 'ObjectTimestamps') {
            return "{$field->name} { createdAt updatedAt }";
        }

        // Skip nested objects without an 'id' field
        if (! $this->typeMapper->hasIdField($type)) {
            return null;
        }

        // Nested objects with 'id' get { id } subselection
        return "{$field->name} { id }";
    }

    /**
     * Convert camelCase to SCREAMING_SNAKE_CASE.
     *
     * Examples:
     * - companyName -> COMPANY_NAME
     * - id -> ID
     * - primaryContact -> PRIMARY_CONTACT
     * - ISO8601DateTime -> ISO8601_DATE_TIME
     */
    public function toScreamingSnakeCase(string $name): string
    {
        // Insert underscore before uppercase letters (but not at the start)
        $result = preg_replace('/(?<!^)([A-Z])/', '_$1', $name);

        return strtoupper($result);
    }
}
