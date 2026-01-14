<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Customer
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Customer extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $contacts,
        public int $orderCount,
        /** @var array<mixed> */
        public array $orders,
        public ?Contact $primaryContact,
        public string $publicUrl,
        /** @var array<mixed> */
        public array $reminders,
        public bool $taxExempt,
        public ?ObjectTimestamps $timestamps = null,
        public ?Address $billingAddress = null,
        public ?string $companyName = null,
        public ?PaymentTerm $defaultPaymentTerm = null,
        public ?string $internalNote = null,
        public ?User $owner = null,
        public ?string $resaleNumber = null,
        public ?float $salesTax = null,
        public ?Address $shippingAddress = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $billingAddress = isset($data['billingAddress']) && is_array($data['billingAddress'])
            ? Address::fromArray($data['billingAddress'])
            : null;

        $defaultPaymentTerm = isset($data['defaultPaymentTerm']) && is_array($data['defaultPaymentTerm'])
            ? PaymentTerm::fromArray($data['defaultPaymentTerm'])
            : null;

        $owner = isset($data['owner']) && is_array($data['owner'])
            ? User::fromArray($data['owner'])
            : null;

        $primaryContact = isset($data['primaryContact']) && is_array($data['primaryContact'])
            ? Contact::fromArray($data['primaryContact'])
            : null;

        $shippingAddress = isset($data['shippingAddress']) && is_array($data['shippingAddress'])
            ? Address::fromArray($data['shippingAddress'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            billingAddress: $billingAddress,
            companyName: $data['companyName'] ?? null,
            contacts: $data['contacts'] ?? [],
            defaultPaymentTerm: $defaultPaymentTerm,
            id: $data['id'] ?? '',
            internalNote: $data['internalNote'] ?? null,
            orderCount: $data['orderCount'] ?? 0,
            orders: $data['orders'] ?? [],
            owner: $owner,
            primaryContact: $primaryContact,
            publicUrl: $data['publicUrl'] ?? '',
            reminders: $data['reminders'] ?? [],
            resaleNumber: $data['resaleNumber'] ?? null,
            salesTax: $data['salesTax'] ?? null,
            shippingAddress: $shippingAddress,
            taxExempt: $data['taxExempt'] ?? false,
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
            'companyName',
            'defaultPaymentTerm { id }',
            'id',
            'internalNote',
            'orderCount',
            'owner { id }',
            'primaryContact { id }',
            'publicUrl',
            'resaleNumber',
            'salesTax',
            'taxExempt',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
