<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Details about a payment request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentRequestDetail extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $orderVisualId,
        public float $requestedAmount,
        public ?ObjectTimestamps $timestamps = null,
        public ?OrderUnion $requestedFor = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $requestedFor = isset($data['requestedFor']) && is_array($data['requestedFor'])
            ? OrderUnion::fromArray($data['requestedFor'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            orderVisualId: $data['orderVisualId'] ?? '',
            requestedAmount: $data['requestedAmount'] ?? 0.0,
            requestedFor: $requestedFor,
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
            'id',
            'orderVisualId',
            'requestedAmount',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
