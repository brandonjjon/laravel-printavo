<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for a preset task
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PresetTaskInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?IDInput $assignedTo = null,
        public ?string $name = null,
        public ?int $position = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $assignedTo = isset($data['assignedTo']) && is_array($data['assignedTo'])
            ? IDInput::fromArray($data['assignedTo'])
            : null;

        return new static(
            assignedTo: $assignedTo,
            name: $data['name'] ?? null,
            position: $data['position'] ?? null,
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
            'assignedTo { id }',
            'name',
            'position',
        ];
    }
}
