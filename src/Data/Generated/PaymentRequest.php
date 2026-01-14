<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\PaymentRequestStatus;
use Carbon\Carbon;

/**
 * Payment request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentRequest extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public float $amount,
        public ?Customer $contact,
        public Carbon $requestedAt,
        public ?User $requestedBy,
        /** @var array<mixed> */
        public array $requestedDetails,
        /** @var array<mixed> */
        public array $requestedFor,
        public ?PaymentRequestStatus $status,
        public ?ObjectTimestamps $timestamps,
        public string $visualId,
        public ?string $description = null,
        public ?string $nickname = null,
        /** @var array<mixed> */
        public ?array $payments = [],
        public ?User $user = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $contact = isset($data['contact']) && is_array($data['contact'])
            ? Customer::fromArray($data['contact'])
            : null;

        $requestedAt = isset($data['requestedAt']) ? Carbon::parse($data['requestedAt']) : Carbon::now();

        $requestedBy = isset($data['requestedBy']) && is_array($data['requestedBy'])
            ? User::fromArray($data['requestedBy'])
            : null;

        $status = isset($data['status']) ? PaymentRequestStatus::tryFrom($data['status']) : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $user = isset($data['user']) && is_array($data['user'])
            ? User::fromArray($data['user'])
            : null;

        return new static(
            amount: $data['amount'] ?? 0.0,
            contact: $contact,
            description: $data['description'] ?? null,
            id: $data['id'] ?? '',
            nickname: $data['nickname'] ?? null,
            payments: $data['payments'] ?? [],
            requestedAt: $requestedAt,
            requestedBy: $requestedBy,
            requestedDetails: $data['requestedDetails'] ?? [],
            requestedFor: $data['requestedFor'] ?? [],
            status: $status,
            timestamps: $timestamps,
            user: $user,
            visualId: $data['visualId'] ?? '',
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
            'contact { id }',
            'description',
            'id',
            'nickname',
            'requestedAt',
            'requestedBy { id }',
            'status',
            'timestamps { createdAt updatedAt }',
            'user { id }',
            'visualId',
        ];
    }
}
