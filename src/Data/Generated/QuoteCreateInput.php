<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Input for creating a quote
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class QuoteCreateInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?IDInput $contact,
        public Carbon $customerDueAt,
        public Carbon $dueAt,
        public ?CustomerAddressInput $billingAddress = null,
        public ?IDInput $contractorProfile = null,
        public ?Carbon $createdAt = null,
        public ?string $customerNote = null,
        public ?IDInput $deliveryMethod = null,
        public ?float $discount = null,
        public ?bool $discountAsPercentage = null,
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
        /** @var array<CustomAddressInput> */
        public array $customAddresses = [],
        /** @var array<FeeInput> */
        public array $fees = [],
        /** @var array<LineItemGroupCreateInput> */
        public array $lineItemGroups = [],
        /** @var array<ProductionFileCreateInput> */
        public array $productionFiles = [],
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

        $customerDueAt = isset($data['customerDueAt']) ? Carbon::parse($data['customerDueAt']) : Carbon::now();

        $deliveryMethod = isset($data['deliveryMethod']) && is_array($data['deliveryMethod'])
            ? IDInput::fromArray($data['deliveryMethod'])
            : null;

        $dueAt = isset($data['dueAt']) ? Carbon::parse($data['dueAt']) : Carbon::now();

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

        $customAddresses = array_map(
            fn (array $item) => CustomAddressInput::fromArray($item),
            $data['customAddresses'] ?? []
        );

        $fees = array_map(
            fn (array $item) => FeeInput::fromArray($item),
            $data['fees'] ?? []
        );

        $lineItemGroups = array_map(
            fn (array $item) => LineItemGroupCreateInput::fromArray($item),
            $data['lineItemGroups'] ?? []
        );

        $productionFiles = array_map(
            fn (array $item) => ProductionFileCreateInput::fromArray($item),
            $data['productionFiles'] ?? []
        );

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
            customAddresses: $customAddresses,
            fees: $fees,
            lineItemGroups: $lineItemGroups,
            productionFiles: $productionFiles,
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
        ];
    }
}
