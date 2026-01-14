<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Line item group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class LineItemGroup extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?LineItemEnabledColumns $enabledColumns,
        /** @var array<mixed> */
        public array $imprints,
        /** @var array<mixed> */
        public array $lineItems,
        public ?OrderUnion $order,
        public int $position,
        public ?ObjectTimestamps $timestamps = null,
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
            ? LineItemEnabledColumns::fromArray($data['enabledColumns'])
            : null;

        $order = isset($data['order']) && is_array($data['order'])
            ? OrderUnion::fromArray($data['order'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            enabledColumns: $enabledColumns,
            id: $data['id'] ?? '',
            imprints: $data['imprints'] ?? [],
            lineItems: $data['lineItems'] ?? [],
            order: $order,
            position: $data['position'] ?? 0,
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
            'id',
            'position',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
