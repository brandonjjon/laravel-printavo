<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Imprint
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ImprintInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?string $details = null,
        public ?IDInput $pricingMatrixColumn = null,
        public ?IDInput $typeOfWork = null,
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
            ? IDInput::fromArray($data['pricingMatrixColumn'])
            : null;

        $typeOfWork = isset($data['typeOfWork']) && is_array($data['typeOfWork'])
            ? IDInput::fromArray($data['typeOfWork'])
            : null;

        return new static(
            details: $data['details'] ?? null,
            pricingMatrixColumn: $pricingMatrixColumn,
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
            'pricingMatrixColumn { id }',
            'typeOfWork { id }',
        ];
    }
}
