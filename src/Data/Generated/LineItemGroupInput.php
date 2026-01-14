<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for a line item group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemGroupInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public int $position,
        public ?LineItemEnabledColumnsInput $enabledColumns = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $enabledColumns = isset($data['enabledColumns']) && is_array($data['enabledColumns'])
            ? LineItemEnabledColumnsInput::fromArray($data['enabledColumns'])
            : null;

        return new static(
            enabledColumns: $enabledColumns,
            position: $data['position'] ?? 0,
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
            'position',
        ];
    }
}
