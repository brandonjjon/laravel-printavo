<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Represents a GraphQL field or input field definition.
 */
readonly class FieldDefinition
{
    /**
     * @param  array<string, ArgumentDefinition>  $args
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public string $type,
        public bool $isNullable,
        public bool $isList,
        public bool $isListItemNullable,
        public array $args = [],
        public bool $isDeprecated = false,
        public ?string $deprecationReason = null,
    ) {}

    /**
     * Create from introspection field array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        [$typeName, $isNullable, $isList, $isListItemNullable] = self::resolveTypeRef($data['type'] ?? []);

        $args = [];
        foreach ($data['args'] ?? [] as $argData) {
            $arg = ArgumentDefinition::fromArray($argData);
            $args[$arg->name] = $arg;
        }

        return new static(
            name: $data['name'] ?? '',
            description: $data['description'] ?? null,
            type: $typeName,
            isNullable: $isNullable,
            isList: $isList,
            isListItemNullable: $isListItemNullable,
            args: $args,
            isDeprecated: $data['isDeprecated'] ?? false,
            deprecationReason: $data['deprecationReason'] ?? null,
        );
    }

    /**
     * Resolve a TypeRef to extract the actual type name, nullability, and list status.
     *
     * Handles nested wrappers like NON_NULL<LIST<NON_NULL<Type>>>
     *
     * @param  array<string, mixed>  $typeRef
     * @return array{0: string, 1: bool, 2: bool, 3: bool} [typeName, isNullable, isList, isListItemNullable]
     */
    protected static function resolveTypeRef(array $typeRef): array
    {
        $isNullable = true;
        $isList = false;
        $isListItemNullable = true;
        $current = $typeRef;

        // First pass: check if the outer type is NON_NULL
        if (isset($current['kind']) && $current['kind'] === 'NON_NULL') {
            $isNullable = false;
            $current = $current['ofType'] ?? [];
        }

        // Check for LIST wrapper
        if (isset($current['kind']) && $current['kind'] === 'LIST') {
            $isList = true;
            $current = $current['ofType'] ?? [];

            // Check if list items are NON_NULL
            if (isset($current['kind']) && $current['kind'] === 'NON_NULL') {
                $isListItemNullable = false;
                $current = $current['ofType'] ?? [];
            }
        }

        // Continue unwrapping any remaining wrappers to get the actual type
        while (isset($current['kind']) && in_array($current['kind'], ['NON_NULL', 'LIST'], true)) {
            $current = $current['ofType'] ?? [];
        }

        return [$current['name'] ?? 'Unknown', $isNullable, $isList, $isListItemNullable];
    }

    /**
     * Convert to array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'isNullable' => $this->isNullable,
            'isList' => $this->isList,
            'isListItemNullable' => $this->isListItemNullable,
            'args' => array_map(fn (ArgumentDefinition $arg) => $arg->toArray(), $this->args),
            'isDeprecated' => $this->isDeprecated,
            'deprecationReason' => $this->deprecationReason,
        ];
    }
}
