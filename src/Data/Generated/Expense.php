<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Expenses
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Expense extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public float $amount,
        public string $name,
        public ?ObjectTimestamps $timestamps,
        public Carbon $transactionAt,
        public bool $userGenerated,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $transactionAt = isset($data['transactionAt']) ? Carbon::parse($data['transactionAt']) : Carbon::now();

        return new static(
            amount: $data['amount'] ?? 0.0,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            timestamps: $timestamps,
            transactionAt: $transactionAt,
            userGenerated: $data['userGenerated'] ?? false,
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
            'id',
            'name',
            'timestamps { createdAt updatedAt }',
            'transactionAt',
            'userGenerated',
        ];
    }
}
