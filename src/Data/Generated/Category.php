<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Category
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Category extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
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
            id: $data['id'] ?? '',
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
            'id',
            'name',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
