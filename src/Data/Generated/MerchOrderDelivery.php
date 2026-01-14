<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\MerchOrderDeliveryMethod;

/**
 * Delivery details for a merch order
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class MerchOrderDelivery extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?MerchOrderDeliveryMethod $method = null,
        public ?bool $flatRate = null,
        public ?float $total = null,
        public ?float $totalActual = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $method = isset($data['method']) ? MerchOrderDeliveryMethod::tryFrom($data['method']) : null;

        return new static(
            flatRate: $data['flatRate'] ?? null,
            method: $method,
            total: $data['total'] ?? null,
            totalActual: $data['totalActual'] ?? null,
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
            'flatRate',
            'method',
            'total',
            'totalActual',
        ];
    }
}
