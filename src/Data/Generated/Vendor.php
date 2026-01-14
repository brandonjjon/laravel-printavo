<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Vendor
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Vendor extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?Address $address,
        public string $company,
        public ?ObjectTimestamps $timestamps = null,
        public ?string $accountNumber = null,
        public ?string $email = null,
        public ?string $fax = null,
        public ?string $name = null,
        public ?string $phone = null,
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
            accountNumber: $data['accountNumber'] ?? null,
            address: $address,
            company: $data['company'] ?? '',
            email: $data['email'] ?? null,
            fax: $data['fax'] ?? null,
            id: $data['id'] ?? '',
            name: $data['name'] ?? null,
            phone: $data['phone'] ?? null,
            timestamps: $timestamps,
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
            'accountNumber',
            'company',
            'email',
            'fax',
            'id',
            'name',
            'phone',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
