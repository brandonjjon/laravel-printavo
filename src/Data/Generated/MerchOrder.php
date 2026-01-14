<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\MerchOrderStatus;
use Carbon\Carbon;

/**
 * Merch order
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class MerchOrder extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?MerchOrderDelivery $delivery,
        public float $itemTotal,
        public float $promoTotal,
        public int $quantity,
        public ?MerchOrderStatus $status,
        public ?MerchStore $store,
        public float $tax,
        public ?ObjectTimestamps $timestamps,
        public float $total,
        public ?MerchAddress $billingAddress = null,
        public ?Carbon $completedAt = null,
        public ?MerchAddress $shippingAddress = null,
        public ?string $visualId = null,
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
            ? MerchAddress::fromArray($data['billingAddress'])
            : null;

        $completedAt = isset($data['completedAt']) ? Carbon::parse($data['completedAt']) : null;

        $delivery = isset($data['delivery']) && is_array($data['delivery'])
            ? MerchOrderDelivery::fromArray($data['delivery'])
            : null;

        $shippingAddress = isset($data['shippingAddress']) && is_array($data['shippingAddress'])
            ? MerchAddress::fromArray($data['shippingAddress'])
            : null;

        $status = isset($data['status']) ? MerchOrderStatus::tryFrom($data['status']) : null;

        $store = isset($data['store']) && is_array($data['store'])
            ? MerchStore::fromArray($data['store'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            billingAddress: $billingAddress,
            completedAt: $completedAt,
            delivery: $delivery,
            id: $data['id'] ?? '',
            itemTotal: $data['itemTotal'] ?? 0.0,
            promoTotal: $data['promoTotal'] ?? 0.0,
            quantity: $data['quantity'] ?? 0,
            shippingAddress: $shippingAddress,
            status: $status,
            store: $store,
            tax: $data['tax'] ?? 0.0,
            timestamps: $timestamps,
            total: $data['total'] ?? 0.0,
            visualId: $data['visualId'] ?? null,
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
            'billingAddress { id }',
            'completedAt',
            'id',
            'itemTotal',
            'promoTotal',
            'quantity',
            'shippingAddress { id }',
            'status',
            'store { id }',
            'tax',
            'timestamps { createdAt updatedAt }',
            'total',
            'visualId',
        ];
    }
}
