<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Account catalog information
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class CatalogInformation extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public bool $alphabroder,
        public bool $sanmar,
        public bool $ssActivewear,
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
            alphabroder: $data['alphabroder'] ?? false,
            sanmar: $data['sanmar'] ?? false,
            ssActivewear: $data['ssActivewear'] ?? false,
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
            'alphabroder',
            'sanmar',
            'ssActivewear',
        ];
    }
}
