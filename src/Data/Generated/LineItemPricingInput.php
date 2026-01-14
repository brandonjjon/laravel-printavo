<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\LineItemStatus;

/**
 * Line item input for pricing a line item group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemPricingInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?IDInput $category = null,
        public ?string $color = null,
        public ?string $description = null,
        public ?string $itemNumber = null,
        public ?IDInput $lineItemGroup = null,
        public ?float $markupPercentage = null,
        public ?int $position = null,
        public ?float $price = null,
        public ?IDInput $product = null,
        public ?LineItemStatus $productStatus = null,
        /** @var array<LineItemSizeCountInput> */
        public array $sizes = [],
        public ?bool $taxed = null,
        public ?string $priceReceiptSignature = null,
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
            ? IDInput::fromArray($data['category'])
            : null;

        $lineItemGroup = isset($data['lineItemGroup']) && is_array($data['lineItemGroup'])
            ? IDInput::fromArray($data['lineItemGroup'])
            : null;

        $product = isset($data['product']) && is_array($data['product'])
            ? IDInput::fromArray($data['product'])
            : null;

        $productStatus = isset($data['productStatus']) ? LineItemStatus::tryFrom($data['productStatus']) : null;

        $sizes = array_map(
            fn (array $item) => LineItemSizeCountInput::fromArray($item),
            $data['sizes'] ?? []
        );

        return new static(
            category: $category,
            color: $data['color'] ?? null,
            description: $data['description'] ?? null,
            itemNumber: $data['itemNumber'] ?? null,
            lineItemGroup: $lineItemGroup,
            markupPercentage: $data['markupPercentage'] ?? null,
            position: $data['position'] ?? null,
            price: $data['price'] ?? null,
            product: $product,
            productStatus: $productStatus,
            sizes: $sizes,
            taxed: $data['taxed'] ?? null,
            priceReceiptSignature: $data['priceReceiptSignature'] ?? null,
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
            'itemNumber',
            'lineItemGroup { id }',
            'markupPercentage',
            'position',
            'price',
            'product { id }',
            'productStatus',
            'taxed',
            'priceReceiptSignature',
        ];
    }
}
