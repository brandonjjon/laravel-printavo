<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LoggedIn extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $token,
        public ?User $user = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $user = isset($data['user']) && is_array($data['user'])
            ? User::fromArray($data['user'])
            : null;

        return new static(
            token: $data['token'] ?? '',
            user: $user,
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
            'token',
            'user { id }',
        ];
    }
}
