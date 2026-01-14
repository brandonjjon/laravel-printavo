<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Payment term
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentTerm extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public bool $archived,
        public int $days,
        public bool $inUse,
        public string $name,
        public ?ObjectTimestamps $timestamps = null,
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

        return new static(
            archived: $data['archived'] ?? false,
            days: $data['days'] ?? 0,
            id: $data['id'] ?? '',
            inUse: $data['inUse'] ?? false,
            name: $data['name'] ?? '',
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
            'archived',
            'days',
            'id',
            'inUse',
            'name',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
