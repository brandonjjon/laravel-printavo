<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\LineItemSize;

/**
 * Line item styles
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemEnabledColumns extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public bool $category,
        public bool $color,
        public bool $itemNumber,
        public bool $markupPercentage,
        /** @var array<LineItemSize> */
        public array $sizes = [],
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $sizes = array_map(
            fn (string $value) => LineItemSize::from($value),
            $data['sizes'] ?? []
        );

        return new static(
            category: $data['category'] ?? false,
            color: $data['color'] ?? false,
            itemNumber: $data['itemNumber'] ?? false,
            markupPercentage: $data['markupPercentage'] ?? false,
            sizes: $sizes,
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
            'category',
            'color',
            'itemNumber',
            'markupPercentage',
            'sizes',
        ];
    }
}
