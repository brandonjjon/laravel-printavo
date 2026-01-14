<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Contractor
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ContractorProfile extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $companyName,
        public ?ObjectTimestamps $timestamps = null,
        public ?Address $address = null,
        public ?string $email = null,
        public ?string $logo = null,
        public ?string $phone = null,
        public ?string $website = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $address = isset($data['address']) && is_array($data['address'])
            ? Address::fromArray($data['address'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            address: $address,
            companyName: $data['companyName'] ?? '',
            email: $data['email'] ?? null,
            id: $data['id'] ?? '',
            logo: $data['logo'] ?? null,
            phone: $data['phone'] ?? null,
            timestamps: $timestamps,
            website: $data['website'] ?? null,
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
            'companyName',
            'email',
            'id',
            'logo',
            'phone',
            'timestamps { createdAt updatedAt }',
            'website',
        ];
    }
}
