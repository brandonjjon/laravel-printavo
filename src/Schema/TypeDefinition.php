<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Represents a GraphQL type definition.
 */
readonly class TypeDefinition
{
    /**
     * @param  array<string, FieldDefinition>  $fields
     * @param  array<string, FieldDefinition>  $inputFields
     * @param  array<string>  $enumValues
     * @param  array<string>  $interfaces
     * @param  array<string>  $possibleTypes
     */
    public function __construct(
        public string $kind,
        public string $name,
        public ?string $description,
        public array $fields = [],
        public array $inputFields = [],
        public array $enumValues = [],
        public array $interfaces = [],
        public array $possibleTypes = [],
    ) {}

    /**
     * Create from introspection type array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $fields = self::parseFields($data['fields'] ?? []);
        $inputFields = self::parseFields($data['inputFields'] ?? []);
        $enumValues = array_column($data['enumValues'] ?? [], 'name');
        $interfaces = array_filter(array_column($data['interfaces'] ?? [], 'name'));
        $possibleTypes = array_filter(array_column($data['possibleTypes'] ?? [], 'name'));

        return new static(
            kind: $data['kind'] ?? 'OBJECT',
            name: $data['name'] ?? '',
            description: $data['description'] ?? null,
            fields: $fields,
            inputFields: $inputFields,
            enumValues: $enumValues,
            interfaces: $interfaces,
            possibleTypes: $possibleTypes,
        );
    }

    /**
     * Parse field definitions from raw array data.
     *
     * @param  array<int, array<string, mixed>>  $fieldsData
     * @return array<string, FieldDefinition>
     */
    private static function parseFields(array $fieldsData): array
    {
        $fields = [];
        foreach ($fieldsData as $fieldData) {
            $field = FieldDefinition::fromArray($fieldData);
            $fields[$field->name] = $field;
        }

        return $fields;
    }

    /**
     * Check if this is an object type.
     */
    public function isObject(): bool
    {
        return $this->kind === 'OBJECT';
    }

    /**
     * Check if this is an input object type.
     */
    public function isInput(): bool
    {
        return $this->kind === 'INPUT_OBJECT';
    }

    /**
     * Check if this is an enum type.
     */
    public function isEnum(): bool
    {
        return $this->kind === 'ENUM';
    }

    /**
     * Check if this is a scalar type.
     */
    public function isScalar(): bool
    {
        return $this->kind === 'SCALAR';
    }

    /**
     * Check if this is an interface type.
     */
    public function isInterface(): bool
    {
        return $this->kind === 'INTERFACE';
    }

    /**
     * Check if this is a union type.
     */
    public function isUnion(): bool
    {
        return $this->kind === 'UNION';
    }

    /**
     * Convert to array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'kind' => $this->kind,
            'name' => $this->name,
            'description' => $this->description,
            'fields' => array_map(fn (FieldDefinition $f) => $f->toArray(), $this->fields),
            'inputFields' => array_map(fn (FieldDefinition $f) => $f->toArray(), $this->inputFields),
            'enumValues' => $this->enumValues,
            'interfaces' => $this->interfaces,
            'possibleTypes' => $this->possibleTypes,
        ];
    }
}
