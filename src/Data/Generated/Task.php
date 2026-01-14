<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Task
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Task extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public bool $completed,
        public Carbon $dueAt,
        public string $name,
        public ?ObjectTimestamps $timestamps = null,
        public ?User $assignedTo = null,
        public ?Carbon $completedAt = null,
        public ?User $completedBy = null,
        public ?string $sourcePresetTaskGroupTitle = null,
        public ?TaskableUnion $taskable = null,
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

        $completedAt = isset($data['completedAt']) ? Carbon::parse($data['completedAt']) : null;

        $completedBy = isset($data['completedBy']) && is_array($data['completedBy'])
            ? User::fromArray($data['completedBy'])
            : null;

        $dueAt = isset($data['dueAt']) ? Carbon::parse($data['dueAt']) : Carbon::now();

        $taskable = isset($data['taskable']) && is_array($data['taskable'])
            ? TaskableUnion::fromArray($data['taskable'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            assignedTo: $assignedTo,
            completed: $data['completed'] ?? false,
            completedAt: $completedAt,
            completedBy: $completedBy,
            dueAt: $dueAt,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            sourcePresetTaskGroupTitle: $data['sourcePresetTaskGroupTitle'] ?? null,
            taskable: $taskable,
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
            'completed',
            'completedAt',
            'completedBy { id }',
            'dueAt',
            'id',
            'name',
            'sourcePresetTaskGroupTitle',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
