<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for updating a fee
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class FeeUpdatesInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?FeeInput $input = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $input = isset($data['input']) && is_array($data['input'])
            ? FeeInput::fromArray($data['input'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            input: $input,
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
        ];
    }
}
