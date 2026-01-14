<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for a payment term
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentTermInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?int $days = null,
        public ?string $name = null,
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
            days: $data['days'] ?? null,
            name: $data['name'] ?? null,
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
            'days',
            'name',
        ];
    }
}
