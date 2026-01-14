<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating a mockup
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ImprintMockupCreatesInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $imprintId,
        public string $publicImageUrl,
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
            imprintId: $data['imprintId'] ?? '',
            publicImageUrl: $data['publicImageUrl'] ?? '',
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
            'imprintId',
            'publicImageUrl',
        ];
    }
}
