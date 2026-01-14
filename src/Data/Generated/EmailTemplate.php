<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Email template
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class EmailTemplate extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?ObjectTimestamps $timestamps = null,
        public ?string $body = null,
        public ?string $name = null,
        public ?string $subject = null,
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
            body: $data['body'] ?? null,
            id: $data['id'] ?? '',
            name: $data['name'] ?? null,
            subject: $data['subject'] ?? null,
            timestamps: $timestamps,
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
            'body',
            'id',
            'name',
            'subject',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
