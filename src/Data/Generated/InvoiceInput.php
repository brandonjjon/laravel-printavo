<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Input for updating an invoice
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class InvoiceInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?CustomerAddressInput $billingAddress = null,
        public ?IDInput $contact = null,
        public ?IDInput $contractorProfile = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $customerDueAt = null,
        public ?string $customerNote = null,
        public ?IDInput $deliveryMethod = null,
        public ?float $discount = null,
        public ?bool $discountAsPercentage = null,
        public ?Carbon $dueAt = null,
        public ?Carbon $invoiceAt = null,
        public ?string $nickname = null,
        public ?IDInput $owner = null,
        public ?Carbon $paymentDueAt = null,
        public ?IDInput $paymentTerm = null,
        public ?string $productionNote = null,
        public ?float $salesTax = null,
        public ?CustomerAddressInput $shippingAddress = null,
        public ?Carbon $startAt = null,
        /** @var array<string> */
        public array $tags = [],
        public ?string $visualPoNumber = null,
        public ?string $visualId = null,
        public ?bool $fulfilled = null,
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
            ? CustomerAddressInput::fromArray($data['billingAddress'])
            : null;

        $contact = isset($data['contact']) && is_array($data['contact'])
            ? IDInput::fromArray($data['contact'])
            : null;

        $contractorProfile = isset($data['contractorProfile']) && is_array($data['contractorProfile'])
            ? IDInput::fromArray($data['contractorProfile'])
            : null;

        $createdAt = isset($data['createdAt']) ? Carbon::parse($data['createdAt']) : null;

        $customerDueAt = isset($data['customerDueAt']) ? Carbon::parse($data['customerDueAt']) : null;

        $deliveryMethod = isset($data['deliveryMethod']) && is_array($data['deliveryMethod'])
            ? IDInput::fromArray($data['deliveryMethod'])
            : null;

        $dueAt = isset($data['dueAt']) ? Carbon::parse($data['dueAt']) : null;

        $invoiceAt = isset($data['invoiceAt']) ? Carbon::parse($data['invoiceAt']) : null;

        $owner = isset($data['owner']) && is_array($data['owner'])
            ? IDInput::fromArray($data['owner'])
            : null;

        $paymentDueAt = isset($data['paymentDueAt']) ? Carbon::parse($data['paymentDueAt']) : null;

        $paymentTerm = isset($data['paymentTerm']) && is_array($data['paymentTerm'])
            ? IDInput::fromArray($data['paymentTerm'])
            : null;

        $shippingAddress = isset($data['shippingAddress']) && is_array($data['shippingAddress'])
            ? CustomerAddressInput::fromArray($data['shippingAddress'])
            : null;

        $startAt = isset($data['startAt']) ? Carbon::parse($data['startAt']) : null;

        return new static(
            billingAddress: $billingAddress,
            contact: $contact,
            contractorProfile: $contractorProfile,
            createdAt: $createdAt,
            customerDueAt: $customerDueAt,
            customerNote: $data['customerNote'] ?? null,
            deliveryMethod: $deliveryMethod,
            discount: $data['discount'] ?? null,
            discountAsPercentage: $data['discountAsPercentage'] ?? null,
            dueAt: $dueAt,
            invoiceAt: $invoiceAt,
            nickname: $data['nickname'] ?? null,
            owner: $owner,
            paymentDueAt: $paymentDueAt,
            paymentTerm: $paymentTerm,
            productionNote: $data['productionNote'] ?? null,
            salesTax: $data['salesTax'] ?? null,
            shippingAddress: $shippingAddress,
            startAt: $startAt,
            tags: $data['tags'] ?? [],
            visualPoNumber: $data['visualPoNumber'] ?? null,
            visualId: $data['visualId'] ?? null,
            fulfilled: $data['fulfilled'] ?? null,
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
            'contact { id }',
            'contractorProfile { id }',
            'createdAt',
            'customerDueAt',
            'customerNote',
            'deliveryMethod { id }',
            'discount',
            'discountAsPercentage',
            'dueAt',
            'invoiceAt',
            'nickname',
            'owner { id }',
            'paymentDueAt',
            'paymentTerm { id }',
            'productionNote',
            'salesTax',
            'startAt',
            'tags',
            'visualPoNumber',
            'visualId',
            'fulfilled',
        ];
    }
}
