<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\LineItemStatus;

/**
 * Order item
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItem extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public int $items,
        public ?LineItemGroup $lineItemGroup,
        public bool $merch,
        /** @var array<mixed> */
        public array $mockups,
        public int $position,
        public bool $taxed,
        public ?ObjectTimestamps $timestamps = null,
        public ?Category $category = null,
        public ?string $color = null,
        public ?string $description = null,
        public ?string $itemNumber = null,
        public ?float $markupPercentage = null,
        /** @var array<Personalization> */
        public array $personalizations = [],
        public ?PoLineItem $poLineItem = null,
        public ?float $price = null,
        public ?LineItemPriceReceipt $priceReceipt = null,
        public ?Product $product = null,
        public ?LineItemStatus $productStatus = null,
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

        $lineItemGroup = isset($data['lineItemGroup']) && is_array($data['lineItemGroup'])
            ? LineItemGroup::fromArray($data['lineItemGroup'])
            : null;

        $personalizations = array_map(
            fn (array $item) => Personalization::fromArray($item),
            $data['personalizations'] ?? []
        );

        $poLineItem = isset($data['poLineItem']) && is_array($data['poLineItem'])
            ? PoLineItem::fromArray($data['poLineItem'])
            : null;

        $priceReceipt = isset($data['priceReceipt']) && is_array($data['priceReceipt'])
            ? LineItemPriceReceipt::fromArray($data['priceReceipt'])
            : null;

        $product = isset($data['product']) && is_array($data['product'])
            ? Product::fromArray($data['product'])
            : null;

        $productStatus = isset($data['productStatus']) ? LineItemStatus::tryFrom($data['productStatus']) : null;

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
            lineItemGroup: $lineItemGroup,
            markupPercentage: $data['markupPercentage'] ?? null,
            merch: $data['merch'] ?? false,
            mockups: $data['mockups'] ?? [],
            personalizations: $personalizations,
            poLineItem: $poLineItem,
            position: $data['position'] ?? 0,
            price: $data['price'] ?? null,
            priceReceipt: $priceReceipt,
            product: $product,
            productStatus: $productStatus,
            sizes: $sizes,
            taxed: $data['taxed'] ?? false,
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
            'lineItemGroup { id }',
            'markupPercentage',
            'merch',
            'poLineItem { id }',
            'position',
            'price',
            'product { id }',
            'productStatus',
            'taxed',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
