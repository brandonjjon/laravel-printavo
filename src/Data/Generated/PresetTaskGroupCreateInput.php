<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating a preset task group
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PresetTaskGroupCreateInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $title,
        /** @var array<PresetTaskCreateInput> */
        public array $presetTasks = [],
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $presetTasks = array_map(
            fn (array $item) => PresetTaskCreateInput::fromArray($item),
            $data['presetTasks'] ?? []
        );

        return new static(
            title: $data['title'] ?? '',
            presetTasks: $presetTasks,
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
            'title',
        ];
    }
}
