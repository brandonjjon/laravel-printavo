<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * A thread
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Thread extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $messages,
        public bool $unread,
        public ?OrderUnion $regarding = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $regarding = isset($data['regarding']) && is_array($data['regarding'])
            ? OrderUnion::fromArray($data['regarding'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            messages: $data['messages'] ?? [],
            regarding: $regarding,
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
            'id',
            'unread',
        ];
    }
}
