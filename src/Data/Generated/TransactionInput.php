<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\TransactionCategory;
use Carbon\Carbon;

/**
 * Input for a transaction
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class TransactionInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?float $amount = null,
        public ?TransactionCategory $category = null,
        public ?Carbon $transactionDate = null,
        public ?string $description = null,
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

        $transactionDate = isset($data['transactionDate']) ? Carbon::parse($data['transactionDate']) : null;

        return new static(
            amount: $data['amount'] ?? null,
            category: $category,
            transactionDate: $transactionDate,
            description: $data['description'] ?? null,
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
            'transactionDate',
            'description',
        ];
    }
}
