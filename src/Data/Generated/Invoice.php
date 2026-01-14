<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Invoice
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Invoice extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $approvalRequests,
        public ?Contact $contact,
        public Carbon $createdAt,
        public Carbon $customerDueAt,
        /** @var array<mixed> */
        public array $fees,
        public Carbon $invoiceAt,
        /** @var array<mixed> */
        public array $lineItemGroups,
        public bool $merch,
        public string $packingSlipUrl,
        public bool $paidInFull,
        public Carbon $paymentDueAt,
        /** @var array<mixed> */
        public array $productionFiles,
        public string $publicHash,
        public string $publicPdf,
        public string $publicUrl,
        public Carbon $startAt,
        public ?Status $status,
        /** @var array<mixed> */
        public array $tasks,
        public ?ObjectTimestamps $timestamps,
        public string $url,
        public string $workorderUrl,
        public ?float $amountOutstanding = null,
        public ?float $amountPaid = null,
        public ?CustomerAddress $billingAddress = null,
        public ?ContractorProfile $contractorProfile = null,
        /** @var array<mixed> */
        public ?array $customAddresses = [],
        public ?string $customerNote = null,
        public ?DeliveryMethod $deliveryMethod = null,
        public ?float $discount = null,
        public ?float $discountAmount = null,
        public ?bool $discountAsPercentage = null,
        public ?Carbon $dueAt = null,
        /** @var array<mixed> */
        public ?array $expenses = [],
        public ?string $nickname = null,
        public ?User $owner = null,
        public ?PaymentRequest $paymentRequest = null,
        public ?PaymentTerm $paymentTerm = null,
        public ?string $productionNote = null,
        public ?float $salesTax = null,
        public ?float $salesTaxAmount = null,
        public ?CustomerAddress $shippingAddress = null,
        public ?float $subtotal = null,
        /** @var array<string> */
        public array $tags = [],
        public ?ThreadSummary $threadSummary = null,
        public ?float $total = null,
        public ?int $totalQuantity = null,
        public ?float $totalUntaxed = null,
        /** @var array<mixed> */
        public ?array $transactions = [],
        public ?string $visualId = null,
        public ?string $visualPoNumber = null,
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
            ? CustomerAddress::fromArray($data['billingAddress'])
            : null;

        $contact = isset($data['contact']) && is_array($data['contact'])
            ? Contact::fromArray($data['contact'])
            : null;

        $contractorProfile = isset($data['contractorProfile']) && is_array($data['contractorProfile'])
            ? ContractorProfile::fromArray($data['contractorProfile'])
            : null;

        $createdAt = isset($data['createdAt']) ? Carbon::parse($data['createdAt']) : Carbon::now();

        $customerDueAt = isset($data['customerDueAt']) ? Carbon::parse($data['customerDueAt']) : Carbon::now();

        $deliveryMethod = isset($data['deliveryMethod']) && is_array($data['deliveryMethod'])
            ? DeliveryMethod::fromArray($data['deliveryMethod'])
            : null;

        $dueAt = isset($data['dueAt']) ? Carbon::parse($data['dueAt']) : null;

        $invoiceAt = isset($data['invoiceAt']) ? Carbon::parse($data['invoiceAt']) : Carbon::now();

        $owner = isset($data['owner']) && is_array($data['owner'])
            ? User::fromArray($data['owner'])
            : null;

        $paymentDueAt = isset($data['paymentDueAt']) ? Carbon::parse($data['paymentDueAt']) : Carbon::now();

        $paymentRequest = isset($data['paymentRequest']) && is_array($data['paymentRequest'])
            ? PaymentRequest::fromArray($data['paymentRequest'])
            : null;

        $paymentTerm = isset($data['paymentTerm']) && is_array($data['paymentTerm'])
            ? PaymentTerm::fromArray($data['paymentTerm'])
            : null;

        $shippingAddress = isset($data['shippingAddress']) && is_array($data['shippingAddress'])
            ? CustomerAddress::fromArray($data['shippingAddress'])
            : null;

        $startAt = isset($data['startAt']) ? Carbon::parse($data['startAt']) : Carbon::now();

        $status = isset($data['status']) && is_array($data['status'])
            ? Status::fromArray($data['status'])
            : null;

        $threadSummary = isset($data['threadSummary']) && is_array($data['threadSummary'])
            ? ThreadSummary::fromArray($data['threadSummary'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            amountOutstanding: $data['amountOutstanding'] ?? null,
            amountPaid: $data['amountPaid'] ?? null,
            approvalRequests: $data['approvalRequests'] ?? [],
            billingAddress: $billingAddress,
            contact: $contact,
            contractorProfile: $contractorProfile,
            createdAt: $createdAt,
            customAddresses: $data['customAddresses'] ?? [],
            customerDueAt: $customerDueAt,
            customerNote: $data['customerNote'] ?? null,
            deliveryMethod: $deliveryMethod,
            discount: $data['discount'] ?? null,
            discountAmount: $data['discountAmount'] ?? null,
            discountAsPercentage: $data['discountAsPercentage'] ?? null,
            dueAt: $dueAt,
            expenses: $data['expenses'] ?? [],
            fees: $data['fees'] ?? [],
            id: $data['id'] ?? '',
            invoiceAt: $invoiceAt,
            lineItemGroups: $data['lineItemGroups'] ?? [],
            merch: $data['merch'] ?? false,
            nickname: $data['nickname'] ?? null,
            owner: $owner,
            packingSlipUrl: $data['packingSlipUrl'] ?? '',
            paidInFull: $data['paidInFull'] ?? false,
            paymentDueAt: $paymentDueAt,
            paymentRequest: $paymentRequest,
            paymentTerm: $paymentTerm,
            productionFiles: $data['productionFiles'] ?? [],
            productionNote: $data['productionNote'] ?? null,
            publicHash: $data['publicHash'] ?? '',
            publicPdf: $data['publicPdf'] ?? '',
            publicUrl: $data['publicUrl'] ?? '',
            salesTax: $data['salesTax'] ?? null,
            salesTaxAmount: $data['salesTaxAmount'] ?? null,
            shippingAddress: $shippingAddress,
            startAt: $startAt,
            status: $status,
            subtotal: $data['subtotal'] ?? null,
            tags: $data['tags'] ?? [],
            tasks: $data['tasks'] ?? [],
            threadSummary: $threadSummary,
            timestamps: $timestamps,
            total: $data['total'] ?? null,
            totalQuantity: $data['totalQuantity'] ?? null,
            totalUntaxed: $data['totalUntaxed'] ?? null,
            transactions: $data['transactions'] ?? [],
            url: $data['url'] ?? '',
            visualId: $data['visualId'] ?? null,
            visualPoNumber: $data['visualPoNumber'] ?? null,
            workorderUrl: $data['workorderUrl'] ?? '',
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
            'amountOutstanding',
            'amountPaid',
            'contact { id }',
            'contractorProfile { id }',
            'createdAt',
            'customerDueAt',
            'customerNote',
            'deliveryMethod { id }',
            'discount',
            'discountAmount',
            'discountAsPercentage',
            'dueAt',
            'id',
            'invoiceAt',
            'merch',
            'nickname',
            'owner { id }',
            'packingSlipUrl',
            'paidInFull',
            'paymentDueAt',
            'paymentRequest { id }',
            'paymentTerm { id }',
            'productionNote',
            'publicHash',
            'publicPdf',
            'publicUrl',
            'salesTax',
            'salesTaxAmount',
            'startAt',
            'status { id }',
            'subtotal',
            'tags',
            'threadSummary { id }',
            'timestamps { createdAt updatedAt }',
            'total',
            'totalQuantity',
            'totalUntaxed',
            'url',
            'visualId',
            'visualPoNumber',
            'workorderUrl',
        ];
    }
}
