<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Address
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Address extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?ObjectTimestamps $timestamps = null,
        public ?string $address1 = null,
        public ?string $address2 = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $countryIso = null,
        public ?string $state = null,
        public ?string $stateIso = null,
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
        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            address1: $data['address1'] ?? null,
            address2: $data['address2'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
            countryIso: $data['countryIso'] ?? null,
            state: $data['state'] ?? null,
            stateIso: $data['stateIso'] ?? null,
            timestamps: $timestamps,
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
            'countryIso',
            'state',
            'stateIso',
            'timestamps { createdAt updatedAt }',
            'zipCode',
        ];
    }
}
