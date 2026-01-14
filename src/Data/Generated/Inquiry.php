<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Inquiry
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Inquiry extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?ObjectTimestamps $timestamps,
        public bool $unread,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $request = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            email: $data['email'] ?? null,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            phone: $data['phone'] ?? null,
            request: $data['request'] ?? null,
            timestamps: $timestamps,
            unread: $data['unread'] ?? false,
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
            'email',
            'id',
            'name',
            'phone',
            'request',
            'timestamps { createdAt updatedAt }',
            'unread',
        ];
    }
}
