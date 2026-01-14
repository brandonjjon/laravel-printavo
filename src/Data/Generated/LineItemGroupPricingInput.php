<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input to price a line item group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemGroupPricingInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?LineItemEnabledColumnsInput $enabledColumns = null,
        public ?int $position = null,
        /** @var array<ImprintInput> */
        public array $imprints = [],
        /** @var array<LineItemPricingInput> */
        public array $lineItems = [],
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

        $imprints = array_map(
            fn (array $item) => ImprintInput::fromArray($item),
            $data['imprints'] ?? []
        );

        $lineItems = array_map(
            fn (array $item) => LineItemPricingInput::fromArray($item),
            $data['lineItems'] ?? []
        );

        return new static(
            enabledColumns: $enabledColumns,
            position: $data['position'] ?? null,
            imprints: $imprints,
            lineItems: $lineItems,
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
