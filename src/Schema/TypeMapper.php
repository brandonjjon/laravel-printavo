<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Maps GraphQL types to PHP types for code generation.
 */
readonly class TypeMapper
{
    /**
     * GraphQL scalar to PHP type mappings.
     *
     * @var array<string, string>
     */
    private const SCALAR_MAPPINGS = [
        'String' => 'string',
        'Int' => 'int',
        'Float' => 'float',
        'Boolean' => 'bool',
        'ID' => 'string',
        'ISO8601DateTime' => 'Carbon',
        'ISO8601Date' => 'Carbon',
    ];

    /**
     * Types that require imports.
     *
     * @var array<string, string>
     */
    private const IMPORT_MAPPINGS = [
        'ISO8601DateTime' => 'Carbon\Carbon',
        'ISO8601Date' => 'Carbon\Carbon',
    ];

    /**
     * PHP primitive types.
     *
     * @var array<string>
     */
    private const PRIMITIVES = ['string', 'int', 'float', 'bool'];

    /**
     * Set of enum type names from the schema.
     *
     * @var array<string, true>
     */
    private array $enumTypes;

    /**
     * Set of type names that have an 'id' field.
     *
     * @var array<string, true>
     */
    private array $typesWithId;

    /**
     * @param  array<string>  $enumTypeNames  List of enum type names from the schema
     * @param  array<string>  $typesWithIdField  List of type names that have an 'id' field
     */
    public function __construct(array $enumTypeNames = [], array $typesWithIdField = [])
    {
        $this->enumTypes = array_fill_keys($enumTypeNames, true);
        $this->typesWithId = array_fill_keys($typesWithIdField, true);
    }

    /**
     * Convert a field to its PHP type string.
     *
     * Returns the appropriate PHP type considering nullability and lists.
     * - If nullable: `?TypeName`
     * - If list: `array`
     */
    public function toPhpType(FieldDefinition $field): string
    {
        if ($field->isList) {
            return 'array';
        }

        $baseType = $this->mapScalar($field->type);

        if ($field->isNullable) {
            return '?'.$baseType;
        }

        return $baseType;
    }

    /**
     * Get the PHPDoc-compatible type for array annotations.
     *
     * Returns types like `array<Customer>` or `array<string>`.
     */
    public function toPhpDocType(FieldDefinition $field): string
    {
        if (! $field->isList) {
            $baseType = $this->mapScalar($field->type);

            return $field->isNullable ? "?{$baseType}" : $baseType;
        }

        $itemType = $this->mapScalar($field->type);

        if ($field->isListItemNullable) {
            return "array<{$itemType}|null>";
        }

        return "array<{$itemType}>";
    }

    /**
     * Check if a GraphQL type is a scalar.
     */
    public function isScalar(string $graphqlType): bool
    {
        return array_key_exists($graphqlType, self::SCALAR_MAPPINGS);
    }

    /**
     * Check if a GraphQL type is an enum.
     */
    public function isEnum(string $graphqlType): bool
    {
        return isset($this->enumTypes[$graphqlType]);
    }

    /**
     * Check if a GraphQL type has an 'id' field.
     *
     * If no types were registered, defaults to true (backward compatibility).
     */
    public function hasIdField(string $graphqlType): bool
    {
        // If no types were registered, assume all types have id (backward compatibility)
        if (empty($this->typesWithId)) {
            return true;
        }

        return isset($this->typesWithId[$graphqlType]);
    }

    /**
     * Check if a GraphQL type maps to a PHP primitive (string, int, float, bool).
     */
    public function isPrimitive(string $graphqlType): bool
    {
        $phpType = self::SCALAR_MAPPINGS[$graphqlType] ?? null;

        return $phpType !== null && in_array($phpType, self::PRIMITIVES, true);
    }

    /**
     * Get the import class name required for a GraphQL type.
     *
     * Returns the fully qualified class name (e.g., Carbon\Carbon) or null if no import needed.
     */
    public function requiresImport(string $graphqlType): ?string
    {
        return self::IMPORT_MAPPINGS[$graphqlType] ?? null;
    }

    /**
     * Check if a type name represents a Connection pagination wrapper.
     *
     * Connection types (*Connection, *Edge, PageInfo) should not have DTOs generated.
     */
    public function isConnectionType(string $typeName): bool
    {
        return str_ends_with($typeName, 'Connection')
            || str_ends_with($typeName, 'Edge')
            || $typeName === 'PageInfo';
    }

    /**
     * Check if a type should have code generated (DTOs, Field constants, etc.).
     *
     * Returns false for Connection/Edge/PageInfo pagination wrappers,
     * Query/Mutation root types, and internal types.
     */
    public function isGeneratableType(TypeDefinition $type): bool
    {
        // Only generate for object and input types
        if (! $type->isObject() && ! $type->isInput()) {
            return false;
        }

        // Skip pagination wrapper types
        if ($this->isConnectionType($type->name)) {
            return false;
        }

        // Skip Query and Mutation root types
        if ($type->name === 'Query' || $type->name === 'Mutation') {
            return false;
        }

        // Skip internal types
        if (str_starts_with($type->name, '__')) {
            return false;
        }

        return true;
    }

    /**
     * Map a GraphQL scalar type to its PHP equivalent.
     *
     * For non-scalar types (objects, inputs, enums), returns the type name as-is.
     */
    private function mapScalar(string $graphqlType): string
    {
        return self::SCALAR_MAPPINGS[$graphqlType] ?? $graphqlType;
    }
}
