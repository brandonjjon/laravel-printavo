<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * A thread summary
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ThreadSummary extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public bool $unread,
        public ?MessageUnion $lastReceivedMessage = null,
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
        $lastReceivedMessage = isset($data['lastReceivedMessage']) && is_array($data['lastReceivedMessage'])
            ? MessageUnion::fromArray($data['lastReceivedMessage'])
            : null;

        $regarding = isset($data['regarding']) && is_array($data['regarding'])
            ? OrderUnion::fromArray($data['regarding'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            lastReceivedMessage: $lastReceivedMessage,
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
