<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Line item price receipt
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemPriceReceipt extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?float $defaultMarkupPercentage = null,
        public ?string $description = null,
        public ?float $price = null,
        public ?string $signature = null,
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
            defaultMarkupPercentage: $data['defaultMarkupPercentage'] ?? null,
            description: $data['description'] ?? null,
            price: $data['price'] ?? null,
            signature: $data['signature'] ?? null,
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
            'defaultMarkupPercentage',
            'description',
            'price',
            'signature',
        ];
    }
}
