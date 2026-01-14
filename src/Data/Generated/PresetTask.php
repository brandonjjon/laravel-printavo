<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Preset Task
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PresetTask extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?ObjectTimestamps $timestamps = null,
        public ?User $assignedTo = null,
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
            ? User::fromArray($data['assignedTo'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            assignedTo: $assignedTo,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            position: $data['position'] ?? null,
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
            'assignedTo { id }',
            'id',
            'name',
            'position',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
