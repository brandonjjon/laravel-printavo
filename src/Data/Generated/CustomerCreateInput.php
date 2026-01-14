<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating a customer
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class CustomerCreateInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?ContactInput $primaryContact = null,
        public ?AddressInput $billingAddress = null,
        public ?string $companyName = null,
        public ?IDInput $defaultPaymentTerm = null,
        public ?string $internalNote = null,
        public ?IDInput $owner = null,
        public ?string $resaleNumber = null,
        public ?float $salesTax = null,
        public ?AddressInput $shippingAddress = null,
        public ?bool $taxExempt = null,
        /** @var array<ContactInput> */
        public array $contacts = [],
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
            ? AddressInput::fromArray($data['billingAddress'])
            : null;

        $defaultPaymentTerm = isset($data['defaultPaymentTerm']) && is_array($data['defaultPaymentTerm'])
            ? IDInput::fromArray($data['defaultPaymentTerm'])
            : null;

        $owner = isset($data['owner']) && is_array($data['owner'])
            ? IDInput::fromArray($data['owner'])
            : null;

        $shippingAddress = isset($data['shippingAddress']) && is_array($data['shippingAddress'])
            ? AddressInput::fromArray($data['shippingAddress'])
            : null;

        $primaryContact = isset($data['primaryContact']) && is_array($data['primaryContact'])
            ? ContactInput::fromArray($data['primaryContact'])
            : null;

        $contacts = array_map(
            fn (array $item) => ContactInput::fromArray($item),
            $data['contacts'] ?? []
        );

        return new static(
            billingAddress: $billingAddress,
            companyName: $data['companyName'] ?? null,
            defaultPaymentTerm: $defaultPaymentTerm,
            internalNote: $data['internalNote'] ?? null,
            owner: $owner,
            resaleNumber: $data['resaleNumber'] ?? null,
            salesTax: $data['salesTax'] ?? null,
            shippingAddress: $shippingAddress,
            taxExempt: $data['taxExempt'] ?? null,
            primaryContact: $primaryContact,
            contacts: $contacts,
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
            'internalNote',
            'owner { id }',
            'resaleNumber',
            'salesTax',
            'taxExempt',
        ];
    }
}
