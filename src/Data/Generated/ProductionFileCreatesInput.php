<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating a production file
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ProductionFileCreatesInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $parentId,
        public string $publicFileUrl,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        return new static(
            parentId: $data['parentId'] ?? '',
            publicFileUrl: $data['publicFileUrl'] ?? '',
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
            'parentId',
            'publicFileUrl',
        ];
    }
}
