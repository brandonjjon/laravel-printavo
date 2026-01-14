<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Pricing matrix
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PricingMatrix extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $cells,
        public string $name,
        public ?ObjectTimestamps $timestamps = null,
        /** @var array<PricingMatrixColumn> */
        public array $columns = [],
        public ?TypeOfWork $typeOfWork = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $columns = array_map(
            fn (array $item) => PricingMatrixColumn::fromArray($item),
            $data['columns'] ?? []
        );

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $typeOfWork = isset($data['typeOfWork']) && is_array($data['typeOfWork'])
            ? TypeOfWork::fromArray($data['typeOfWork'])
            : null;

        return new static(
            cells: $data['cells'] ?? [],
            columns: $columns,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            timestamps: $timestamps,
            typeOfWork: $typeOfWork,
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
            'typeOfWork { id }',
        ];
    }
}
