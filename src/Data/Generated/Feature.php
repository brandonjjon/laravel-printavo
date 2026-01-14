<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Feature
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Feature extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $key,
        public ?FeatureRestriction $restriction = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $restriction = isset($data['restriction']) && is_array($data['restriction'])
            ? FeatureRestriction::fromArray($data['restriction'])
            : null;

        return new static(
            key: $data['key'] ?? '',
            restriction: $restriction,
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
            'key',
        ];
    }
}
