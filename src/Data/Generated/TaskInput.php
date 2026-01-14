<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Input for a task
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class TaskInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public ?IDInput $assignedTo = null,
        public ?bool $completed = null,
        public ?Carbon $dueAt = null,
        public ?string $name = null,
        public ?TaskableInput $taskable = null,
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

        $dueAt = isset($data['dueAt']) ? Carbon::parse($data['dueAt']) : null;

        $taskable = isset($data['taskable']) && is_array($data['taskable'])
            ? TaskableInput::fromArray($data['taskable'])
            : null;

        return new static(
            assignedTo: $assignedTo,
            completed: $data['completed'] ?? null,
            dueAt: $dueAt,
            name: $data['name'] ?? null,
            taskable: $taskable,
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
            'completed',
            'dueAt',
            'name',
            'taskable { id }',
        ];
    }
}
