<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\ApprovalRequestStatus;

/**
 * Approval request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ApprovalRequest extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?User $requester = null,
        public ?ApprovalRequestStatus $status = null,
        public ?ObjectTimestamps $timestamps = null,
        public ?ApprovalRequestResponse $response = null,
        public ?User $retractor = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $requester = isset($data['requester']) && is_array($data['requester'])
            ? User::fromArray($data['requester'])
            : null;

        $response = isset($data['response']) && is_array($data['response'])
            ? ApprovalRequestResponse::fromArray($data['response'])
            : null;

        $retractor = isset($data['retractor']) && is_array($data['retractor'])
            ? User::fromArray($data['retractor'])
            : null;

        $status = isset($data['status']) ? ApprovalRequestStatus::tryFrom($data['status']) : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            requester: $requester,
            response: $response,
            retractor: $retractor,
            status: $status,
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
            'name',
            'requester { id }',
            'retractor { id }',
            'status',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
