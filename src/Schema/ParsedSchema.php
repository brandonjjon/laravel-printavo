<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Represents a parsed GraphQL schema from introspection.
 */
readonly class ParsedSchema
{
    /**
     * @param  array<string, TypeDefinition>  $types
     */
    public function __construct(
        public string $queryTypeName,
        public ?string $mutationTypeName,
        public array $types,
    ) {}

    /**
     * Create from raw introspection data.
     *
     * Note: This expects the __schema object from the introspection response.
     * Use SchemaParser::parse() for full introspection response handling.
     *
     * @param  array<string, mixed>  $schemaData  The __schema object
     */
    public static function fromIntrospection(array $schemaData): static
    {
        $queryTypeName = $schemaData['queryType']['name'] ?? 'Query';
        $mutationTypeName = $schemaData['mutationType']['name'] ?? null;

        $types = [];
        foreach ($schemaData['types'] ?? [] as $typeData) {
            $name = $typeData['name'] ?? '';

            // Skip introspection types
            if (str_starts_with($name, '__')) {
                continue;
            }

            $type = TypeDefinition::fromArray($typeData);
            $types[$type->name] = $type;
        }

        return new static(
            queryTypeName: $queryTypeName,
            mutationTypeName: $mutationTypeName,
            types: $types,
        );
    }

    /**
     * Get a type by name.
     */
    public function getType(string $name): ?TypeDefinition
    {
        return $this->types[$name] ?? null;
    }

    /**
     * Get the query root type.
     */
    public function getQueryType(): ?TypeDefinition
    {
        return $this->getType($this->queryTypeName);
    }

    /**
     * Get the mutation root type.
     */
    public function getMutationType(): ?TypeDefinition
    {
        if ($this->mutationTypeName === null) {
            return null;
        }

        return $this->getType($this->mutationTypeName);
    }

    /**
     * Get all object types (excluding introspection types).
     *
     * @return array<string, TypeDefinition>
     */
    public function getObjectTypes(): array
    {
        return array_filter(
            $this->types,
            fn (TypeDefinition $type) => $type->isObject() && ! str_starts_with($type->name, '__')
        );
    }

    /**
     * Get all input object types.
     *
     * @return array<string, TypeDefinition>
     */
    public function getInputTypes(): array
    {
        return array_filter(
            $this->types,
            fn (TypeDefinition $type) => $type->isInput()
        );
    }

    /**
     * Get all enum types (excluding introspection types).
     *
     * @return array<string, TypeDefinition>
     */
    public function getEnumTypes(): array
    {
        return array_filter(
            $this->types,
            fn (TypeDefinition $type) => $type->isEnum() && ! str_starts_with($type->name, '__')
        );
    }

    /**
     * Get all scalar types.
     *
     * @return array<string, TypeDefinition>
     */
    public function getScalarTypes(): array
    {
        return array_filter(
            $this->types,
            fn (TypeDefinition $type) => $type->isScalar()
        );
    }

    /**
     * Get all interface types.
     *
     * @return array<string, TypeDefinition>
     */
    public function getInterfaceTypes(): array
    {
        return array_filter(
            $this->types,
            fn (TypeDefinition $type) => $type->isInterface() && ! str_starts_with($type->name, '__')
        );
    }

    /**
     * Get names of all types that have an 'id' field.
     *
     * @return array<string>
     */
    public function getTypesWithIdField(): array
    {
        $typesWithId = [];

        foreach ($this->types as $type) {
            if (! $type->isObject() && ! $type->isInput()) {
                continue;
            }

            $fields = $type->isInput() ? $type->inputFields : $type->fields;

            if (isset($fields['id'])) {
                $typesWithId[] = $type->name;
            }
        }

        return $typesWithId;
    }

    /**
     * Convert to array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'queryTypeName' => $this->queryTypeName,
            'mutationTypeName' => $this->mutationTypeName,
            'types' => array_map(fn (TypeDefinition $t) => $t->toArray(), $this->types),
        ];
    }
}
