<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\LineItemSize;

/**
 * Input for updating line Item's styles
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemSizeCountInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?LineItemSize $size = null,
        public ?int $count = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $size = isset($data['size']) ? LineItemSize::tryFrom($data['size']) : null;

        return new static(
            count: $data['count'] ?? null,
            size: $size,
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
            'count',
            'size',
        ];
    }
}
