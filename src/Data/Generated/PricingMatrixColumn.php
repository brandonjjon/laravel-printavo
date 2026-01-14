<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Pricing matrix column
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PricingMatrixColumn extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $cells,
        public string $columnId,
        public string $columnName,
        public ?PricingMatrix $matrix = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $matrix = isset($data['matrix']) && is_array($data['matrix'])
            ? PricingMatrix::fromArray($data['matrix'])
            : null;

        return new static(
            cells: $data['cells'] ?? [],
            columnId: $data['columnId'] ?? '',
            columnName: $data['columnName'] ?? '',
            id: $data['id'] ?? '',
            matrix: $matrix,
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
            'columnId',
            'columnName',
            'id',
            'matrix { id }',
        ];
    }
}
