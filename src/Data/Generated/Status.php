<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\StatusType;

/**
 * Order status
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Status extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $color,
        public string $name,
        public int $position,
        public ?ObjectTimestamps $timestamps = null,
        public ?StatusType $type = null,
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

        $type = isset($data['type']) ? StatusType::tryFrom($data['type']) : null;

        return new static(
            color: $data['color'] ?? '',
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            position: $data['position'] ?? 0,
            timestamps: $timestamps,
            type: $type,
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
            'color',
            'id',
            'name',
            'position',
            'timestamps { createdAt updatedAt }',
            'type',
        ];
    }
}
