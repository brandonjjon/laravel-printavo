<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Social Links
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Social extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?string $facebookLink = null,
        public ?string $instagramLink = null,
        public ?string $twitterLink = null,
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
            facebookLink: $data['facebookLink'] ?? null,
            instagramLink: $data['instagramLink'] ?? null,
            twitterLink: $data['twitterLink'] ?? null,
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
            'facebookLink',
            'instagramLink',
            'twitterLink',
        ];
    }
}
