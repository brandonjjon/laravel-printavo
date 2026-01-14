<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\MerchStoreStatus;
use Carbon\Carbon;

/**
 * Merch store
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class MerchStore extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $name,
        /** @var array<mixed> */
        public array $orders = [],
        public ?MerchStoreStatus $status = null,
        public ?MerchStoreSummary $summary = null,
        public ?ObjectTimestamps $timestamps = null,
        public ?Carbon $closesAt = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $closesAt = isset($data['closesAt']) ? Carbon::parse($data['closesAt']) : null;

        $status = isset($data['status']) ? MerchStoreStatus::tryFrom($data['status']) : null;

        $summary = isset($data['summary']) && is_array($data['summary'])
            ? MerchStoreSummary::fromArray($data['summary'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            closesAt: $closesAt,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            orders: $data['orders'] ?? [],
            status: $status,
            summary: $summary,
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
            'closesAt',
            'id',
            'name',
            'status',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
