<?php

namespace Brandonjjon\Printavo\Data;

abstract readonly class BaseData
{
    /**
     * Create a new data instance.
     *
     * @param  array<string, mixed>  $attributes  Raw API data for accessing unmapped fields
     */
    public function __construct(
        public string $id,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        return new static(
            id: $data['id'] ?? '',
            attributes: $data,
        );
    }

    /**
     * Create a collection of instances from an array of API response data.
     *
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, static>
     */
    public static function collection(array $items): array
    {
        return array_map(
            fn (array $item): static => static::fromArray($item),
            $items
        );
    }

    /**
     * Access unmapped attributes from the raw API data.
     */
    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Check if an unmapped attribute exists.
     */
    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Get all raw attributes.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
