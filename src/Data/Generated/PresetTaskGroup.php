<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Preset Task Group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PresetTaskGroup extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $presetTasks,
        public ?ObjectTimestamps $timestamps,
        public string $title,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            id: $data['id'] ?? '',
            presetTasks: $data['presetTasks'] ?? [],
            timestamps: $timestamps,
            title: $data['title'] ?? '',
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
            'timestamps { createdAt updatedAt }',
            'title',
        ];
    }
}
