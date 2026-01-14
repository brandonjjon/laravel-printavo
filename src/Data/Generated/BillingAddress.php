<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Billing Address
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class BillingAddress extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?string $address1 = null,
        public ?string $address2 = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $fullName = null,
        public ?string $phone = null,
        public ?string $state = null,
        public ?string $zipCode = null,
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
            address1: $data['address1'] ?? null,
            address2: $data['address2'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
            fullName: $data['fullName'] ?? null,
            phone: $data['phone'] ?? null,
            state: $data['state'] ?? null,
            zipCode: $data['zipCode'] ?? null,
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
            'address1',
            'address2',
            'city',
            'country',
            'fullName',
            'phone',
            'state',
            'zipCode',
        ];
    }
}
