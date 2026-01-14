<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Mockup
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Mockup extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?ObjectTimestamps $timestamps = null,
        public ?bool $displayThumbnail = null,
        public ?string $fullImageUrl = null,
        public ?string $mimeType = null,
        public ?string $thumbnailUrl = null,
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
            displayThumbnail: $data['displayThumbnail'] ?? null,
            fullImageUrl: $data['fullImageUrl'] ?? null,
            id: $data['id'] ?? '',
            mimeType: $data['mimeType'] ?? null,
            thumbnailUrl: $data['thumbnailUrl'] ?? null,
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
            'displayThumbnail',
            'fullImageUrl',
            'id',
            'mimeType',
            'thumbnailUrl',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
