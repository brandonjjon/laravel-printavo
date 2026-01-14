<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Merch store summary
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class MerchStoreSummary extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public int $itemsSold,
        public float $totalSales,
        public float $totalTax,
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
            itemsSold: $data['itemsSold'] ?? 0,
            totalSales: $data['totalSales'] ?? 0.0,
            totalTax: $data['totalTax'] ?? 0.0,
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
            'itemsSold',
            'totalSales',
            'totalTax',
        ];
    }
}
