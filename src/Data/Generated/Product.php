<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Product
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Product extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?string $brand = null,
        public ?ProductCatalog $catalog = null,
        public ?string $color = null,
        public ?string $description = null,
        public ?string $itemNumber = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $catalog = isset($data['catalog']) && is_array($data['catalog'])
            ? ProductCatalog::fromArray($data['catalog'])
            : null;

        return new static(
            brand: $data['brand'] ?? null,
            catalog: $catalog,
            color: $data['color'] ?? null,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            itemNumber: $data['itemNumber'] ?? null,
            attributes: $data,
        );
    }

    /**
     * Get the default fields to request from the API.
     *
     * @return array<string>
     */
    public static function defaultFields(): array
    {
        return [
            'brand',
            'catalog { id }',
            'color',
            'description',
            'id',
            'itemNumber',
        ];
    }
}
