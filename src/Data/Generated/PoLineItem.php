<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Purchase order line item
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PoLineItem extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public int $items,
        public int $position,
        public ?PurchaseOrder $purchaseOrder = null,
        public ?ObjectTimestamps $timestamps = null,
        public ?Category $category = null,
        public ?string $color = null,
        public ?string $description = null,
        public ?string $itemNumber = null,
        /** @var array<LineItemSizeCount> */
        public array $sizes = [],
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $category = isset($data['category']) && is_array($data['category'])
            ? Category::fromArray($data['category'])
            : null;

        $purchaseOrder = isset($data['purchaseOrder']) && is_array($data['purchaseOrder'])
            ? PurchaseOrder::fromArray($data['purchaseOrder'])
            : null;

        $sizes = array_map(
            fn (array $item) => LineItemSizeCount::fromArray($item),
            $data['sizes'] ?? []
        );

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            category: $category,
            color: $data['color'] ?? null,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            itemNumber: $data['itemNumber'] ?? null,
            items: $data['items'] ?? 0,
            position: $data['position'] ?? 0,
            purchaseOrder: $purchaseOrder,
            sizes: $sizes,
            timestamps: $timestamps,
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
            'category { id }',
            'color',
            'description',
            'id',
            'itemNumber',
            'items',
            'position',
            'purchaseOrder { id }',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
