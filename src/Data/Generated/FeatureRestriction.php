<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Feature restriction details
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class FeatureRestriction extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public int $currentUsage,
        public int $limit,
        public ?Carbon $resetsAt = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $resetsAt = isset($data['resetsAt']) ? Carbon::parse($data['resetsAt']) : null;

        return new static(
            currentUsage: $data['currentUsage'] ?? 0,
            limit: $data['limit'] ?? 0,
            resetsAt: $resetsAt,
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
            'currentUsage',
            'limit',
            'resetsAt',
        ];
    }
}
