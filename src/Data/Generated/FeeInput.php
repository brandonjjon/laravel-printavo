<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for a fee
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class FeeInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?float $amount = null,
        public ?string $description = null,
        public ?int $quantity = null,
        public ?bool $taxable = null,
        public ?float $unitPrice = null,
        public ?bool $unitPriceAsPercentage = null,
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
            amount: $data['amount'] ?? null,
            description: $data['description'] ?? null,
            quantity: $data['quantity'] ?? null,
            taxable: $data['taxable'] ?? null,
            unitPrice: $data['unitPrice'] ?? null,
            unitPriceAsPercentage: $data['unitPriceAsPercentage'] ?? null,
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
            'amount',
            'description',
            'quantity',
            'taxable',
            'unitPrice',
            'unitPriceAsPercentage',
        ];
    }
}
