<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\PoGoodsStatus;

/**
 * Purchase order
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PurchaseOrder extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?PoGoodsStatus $goodsStatus,
        /** @var array<mixed> */
        public array $lineItems,
        public ?ObjectTimestamps $timestamps,
        public ?Vendor $vendor,
        public string $visualPoId,
        public ?string $note = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $goodsStatus = isset($data['goodsStatus']) ? PoGoodsStatus::tryFrom($data['goodsStatus']) : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $vendor = isset($data['vendor']) && is_array($data['vendor'])
            ? Vendor::fromArray($data['vendor'])
            : null;

        return new static(
            goodsStatus: $goodsStatus,
            id: $data['id'] ?? '',
            lineItems: $data['lineItems'] ?? [],
            note: $data['note'] ?? null,
            timestamps: $timestamps,
            vendor: $vendor,
            visualPoId: $data['visualPoId'] ?? '',
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
            'goodsStatus',
            'id',
            'note',
            'timestamps { createdAt updatedAt }',
            'vendor { id }',
            'visualPoId',
        ];
    }
}
