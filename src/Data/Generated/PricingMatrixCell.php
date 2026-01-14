<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Pricing matrix cell
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PricingMatrixCell extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?PricingMatrixColumn $column = null,
        public ?PricingMatrix $matrix = null,
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
        $column = isset($data['column']) && is_array($data['column'])
            ? PricingMatrixColumn::fromArray($data['column'])
            : null;

        $matrix = isset($data['matrix']) && is_array($data['matrix'])
            ? PricingMatrix::fromArray($data['matrix'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            column: $column,
            id: $data['id'] ?? '',
            matrix: $matrix,
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
            'column { id }',
            'id',
            'matrix { id }',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
