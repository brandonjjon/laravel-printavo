<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Customer contact
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Contact extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?Customer $customer = null,
        /** @var array<mixed> */
        public array $orders = [],
        public ?ObjectTimestamps $timestamps = null,
        public ?string $email = null,
        public ?string $fax = null,
        public ?string $firstName = null,
        public ?string $fullName = null,
        public ?string $lastName = null,
        public ?int $orderCount = null,
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
        $customer = isset($data['customer']) && is_array($data['customer'])
            ? Customer::fromArray($data['customer'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            customer: $customer,
            email: $data['email'] ?? null,
            fax: $data['fax'] ?? null,
            firstName: $data['firstName'] ?? null,
            fullName: $data['fullName'] ?? null,
            id: $data['id'] ?? '',
            lastName: $data['lastName'] ?? null,
            orderCount: $data['orderCount'] ?? null,
            orders: $data['orders'] ?? [],
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
            'customer { id }',
            'email',
            'fax',
            'firstName',
            'fullName',
            'id',
            'lastName',
            'orderCount',
            'phone',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
