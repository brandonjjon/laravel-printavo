<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Imprints
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Imprint extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $mockups = [],
        public ?ObjectTimestamps $timestamps = null,
        public ?string $details = null,
        public ?PricingMatrixColumn $pricingMatrixColumn = null,
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
        $pricingMatrixColumn = isset($data['pricingMatrixColumn']) && is_array($data['pricingMatrixColumn'])
            ? PricingMatrixColumn::fromArray($data['pricingMatrixColumn'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        $typeOfWork = isset($data['typeOfWork']) && is_array($data['typeOfWork'])
            ? TypeOfWork::fromArray($data['typeOfWork'])
            : null;

        return new static(
            details: $data['details'] ?? null,
            id: $data['id'] ?? '',
            mockups: $data['mockups'] ?? [],
            pricingMatrixColumn: $pricingMatrixColumn,
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
            'details',
            'id',
            'pricingMatrixColumn { id }',
            'timestamps { createdAt updatedAt }',
            'typeOfWork { id }',
        ];
    }
}
