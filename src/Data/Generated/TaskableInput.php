<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\TaskableType;

/**
 * Input for a taskable (Quote, Invoice, or Customer)
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class TaskableInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?TaskableType $type = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $type = isset($data['type']) ? TaskableType::tryFrom($data['type']) : null;

        return new static(
            id: $data['id'] ?? '',
            type: $type,
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
            'type',
        ];
    }
}
