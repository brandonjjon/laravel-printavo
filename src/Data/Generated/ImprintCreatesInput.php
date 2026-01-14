<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating an imprint
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ImprintCreatesInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?ImprintCreateInput $input,
        public string $lineItemGroupId,
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
            ? ImprintCreateInput::fromArray($data['input'])
            : null;

        return new static(
            input: $input,
            lineItemGroupId: $data['lineItemGroupId'] ?? '',
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
            'lineItemGroupId',
        ];
    }
}
