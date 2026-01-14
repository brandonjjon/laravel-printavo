<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Represents a GraphQL argument definition.
 */
readonly class ArgumentDefinition
{
    public function __construct(
        public string $name,
        public ?string $description,
        public string $type,
        public bool $isNullable,
        public bool $isList,
        public ?string $defaultValue = null,
    ) {}

    /**
     * Create from introspection inputValue array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        [$typeName, $isNullable, $isList] = self::resolveTypeRef($data['type'] ?? []);

        return new static(
            name: $data['name'] ?? '',
            description: $data['description'] ?? null,
            type: $typeName,
            isNullable: $isNullable,
            isList: $isList,
            defaultValue: $data['defaultValue'] ?? null,
        );
    }

    /**
     * Resolve a TypeRef to extract the actual type name and nullability.
     *
     * @param  array<string, mixed>  $typeRef
     * @return array{0: string, 1: bool, 2: bool} [typeName, isNullable, isList]
     */
    protected static function resolveTypeRef(array $typeRef): array
    {
        $isNullable = true;
        $isList = false;
        $current = $typeRef;

        // Unwrap NON_NULL and LIST wrappers
        while (isset($current['kind'])) {
            if ($current['kind'] === 'NON_NULL') {
                $isNullable = false;
                $current = $current['ofType'] ?? [];
            } elseif ($current['kind'] === 'LIST') {
                $isList = true;
                $current = $current['ofType'] ?? [];
            } else {
                break;
            }
        }

        return [$current['name'] ?? 'Unknown', $isNullable, $isList];
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
            'defaultValue' => $this->defaultValue,
        ];
    }
}
