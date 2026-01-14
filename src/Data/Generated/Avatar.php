<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * User Avatar
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Avatar extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?string $backgroundColor = null,
        public ?string $initials = null,
        public ?string $urlSmall = null,
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
            backgroundColor: $data['backgroundColor'] ?? null,
            initials: $data['initials'] ?? null,
            urlSmall: $data['urlSmall'] ?? null,
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
            'backgroundColor',
            'initials',
            'urlSmall',
        ];
    }
}
