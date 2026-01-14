<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for a contact
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ContactInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?string $fax = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $phone = null,
        /** @var array<string> */
        public array $email = [],
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
            fax: $data['fax'] ?? null,
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            email: $data['email'] ?? [],
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
            'fax',
            'firstName',
            'lastName',
            'phone',
            'email',
        ];
    }
}
