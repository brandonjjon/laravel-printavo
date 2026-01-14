<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Production file
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ProductionFile extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $fileUrl,
        public string $mimeType,
        public ?ObjectTimestamps $timestamps = null,
        public ?string $name = null,
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
            fileUrl: $data['fileUrl'] ?? '',
            id: $data['id'] ?? '',
            mimeType: $data['mimeType'] ?? '',
            name: $data['name'] ?? null,
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
            'fileUrl',
            'id',
            'mimeType',
            'name',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
