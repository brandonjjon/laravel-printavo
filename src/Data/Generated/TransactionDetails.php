<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\TransactionCategory;
use Carbon\Carbon;

/**
 * Transaction details
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class TransactionDetails extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public float $amount,
        public ?BillingAddress $billingAddress,
        public ?Payment $originatingPaymentTransaction,
        public bool $processing,
        public ?ObjectTimestamps $timestamps,
        public Carbon $transactionDate,
        /** @var array<mixed> */
        public array $transactions = [],
        public ?TransactionCategory $category = null,
        public ?string $ccCardType = null,
        public ?string $ccLastFour = null,
        public ?string $description = null,
        public ?OrderUnion $order = null,
        public ?string $portalTransactionId = null,
        public ?TransactedForUnion $transactedFor = null,
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
            ? BillingAddress::fromArray($data['billingAddress'])
            : null;

        $category = isset($data['category']) ? TransactionCategory::tryFrom($data['category']) : null;

        $order = isset($data['order']) && is_array($data['order'])
            ? OrderUnion::fromArray($data['order'])
            : null;

        $originatingPaymentTransaction = isset($data['originatingPaymentTransaction']) && is_array($data['originatingPaymentTransaction'])
            ? Payment::fromArray($data['originatingPaymentTransaction'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $transactedFor = isset($data['transactedFor']) && is_array($data['transactedFor'])
            ? TransactedForUnion::fromArray($data['transactedFor'])
            : null;

        $transactionDate = isset($data['transactionDate']) ? Carbon::parse($data['transactionDate']) : Carbon::now();

        return new static(
            amount: $data['amount'] ?? 0.0,
            billingAddress: $billingAddress,
            category: $category,
            ccCardType: $data['ccCardType'] ?? null,
            ccLastFour: $data['ccLastFour'] ?? null,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            order: $order,
            originatingPaymentTransaction: $originatingPaymentTransaction,
            portalTransactionId: $data['portalTransactionId'] ?? null,
            processing: $data['processing'] ?? false,
            timestamps: $timestamps,
            transactedFor: $transactedFor,
            transactionDate: $transactionDate,
            transactions: $data['transactions'] ?? [],
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
            'amount',
            'category',
            'ccCardType',
            'ccLastFour',
            'description',
            'id',
            'originatingPaymentTransaction { id }',
            'portalTransactionId',
            'processing',
            'timestamps { createdAt updatedAt }',
            'transactionDate',
        ];
    }
}
