<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\PaymentDisputeStatusField;
use Brandonjjon\Printavo\Data\Generated\Enums\TransactionCategory;
use Carbon\Carbon;

/**
 * Payment Dispute
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentDispute extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public float $amount,
        public ?Payment $originatingPaymentTransaction,
        public bool $processing,
        public ?ObjectTimestamps $timestamps,
        public Carbon $transactionDate,
        public ?TransactionCategory $category = null,
        public ?string $description = null,
        public ?OrderUnion $order = null,
        public ?PaymentDisputeStatusField $status = null,
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
        $category = isset($data['category']) ? TransactionCategory::tryFrom($data['category']) : null;

        $order = isset($data['order']) && is_array($data['order'])
            ? OrderUnion::fromArray($data['order'])
            : null;

        $originatingPaymentTransaction = isset($data['originatingPaymentTransaction']) && is_array($data['originatingPaymentTransaction'])
            ? Payment::fromArray($data['originatingPaymentTransaction'])
            : null;

        $status = isset($data['status']) ? PaymentDisputeStatusField::tryFrom($data['status']) : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $transactedFor = isset($data['transactedFor']) && is_array($data['transactedFor'])
            ? TransactedForUnion::fromArray($data['transactedFor'])
            : null;

        $transactionDate = isset($data['transactionDate']) ? Carbon::parse($data['transactionDate']) : Carbon::now();

        return new static(
            amount: $data['amount'] ?? 0.0,
            category: $category,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            order: $order,
            originatingPaymentTransaction: $originatingPaymentTransaction,
            processing: $data['processing'] ?? false,
            status: $status,
            timestamps: $timestamps,
            transactedFor: $transactedFor,
            transactionDate: $transactionDate,
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
            'description',
            'id',
            'originatingPaymentTransaction { id }',
            'processing',
            'status',
            'timestamps { createdAt updatedAt }',
            'transactionDate',
        ];
    }
}
