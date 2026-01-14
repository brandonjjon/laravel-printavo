<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * User Permissions
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Permission extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public bool $enabled,
        public string $key,
        public string $name,
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
            enabled: $data['enabled'] ?? false,
            key: $data['key'] ?? '',
            name: $data['name'] ?? '',
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
            'enabled',
            'key',
            'name',
        ];
    }
}
