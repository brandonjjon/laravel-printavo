<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Approval request response details
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ApprovalRequestResponse extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $name,
        public Carbon $respondedAt,
        public ?string $email = null,
        public ?string $reason = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $respondedAt = isset($data['respondedAt']) ? Carbon::parse($data['respondedAt']) : Carbon::now();

        return new static(
            email: $data['email'] ?? null,
            name: $data['name'] ?? '',
            reason: $data['reason'] ?? null,
            respondedAt: $respondedAt,
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
            'email',
            'name',
            'reason',
            'respondedAt',
        ];
    }
}
