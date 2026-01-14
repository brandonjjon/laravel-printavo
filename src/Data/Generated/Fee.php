<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Fees
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Fee extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?ObjectTimestamps $timestamps = null,
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
        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            amount: $data['amount'] ?? null,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            quantity: $data['quantity'] ?? null,
            taxable: $data['taxable'] ?? null,
            timestamps: $timestamps,
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
            'id',
            'quantity',
            'taxable',
            'timestamps { createdAt updatedAt }',
            'unitPrice',
            'unitPriceAsPercentage',
        ];
    }
}
