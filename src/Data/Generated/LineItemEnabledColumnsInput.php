<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\LineItemSize;

/**
 * Input for a line item group enabled columns
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemEnabledColumnsInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?bool $category = null,
        public ?bool $color = null,
        public ?bool $itemNumber = null,
        public ?bool $markupPercentage = null,
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
            category: $data['category'] ?? null,
            color: $data['color'] ?? null,
            itemNumber: $data['itemNumber'] ?? null,
            markupPercentage: $data['markupPercentage'] ?? null,
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
