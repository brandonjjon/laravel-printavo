<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Enums\TaskSortField;
use Brandonjjon\Printavo\Data\Generated\Task;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for tasks collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class TasksBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'tasks';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'task';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Task>
     */
    protected string $dataClass = Task::class;

    /**
     * The fields to select.
     *
     * @var array<string>
     */
    protected array $selects = [];

    /**
     * Create a new builder instance.
     */
    public function __construct(PrintavoClient $client)
    {
        parent::__construct($client);
        $this->selects = Task::defaultFields();
    }

    /**
     * Find only tasks assigned to this User
     */
    public function assigneeId(string $value): static
    {
        return $this->whereTyped('assigneeId', $value, 'ID');
    }

    /**
     * Search only for completed tasks?
     */
    public function completed(bool $value): static
    {
        return $this->whereTyped('completed', $value, 'Boolean');
    }

    /**
     * Find any tasks with a due date after this date
     */
    public function dueAfter(string|\DateTimeInterface $value): static
    {
        return $this->whereTyped('dueAfter', $this->formatDate($value), 'ISO8601DateTime');
    }

    /**
     * Find any tasks with a due date before this date
     */
    public function dueBefore(string|\DateTimeInterface $value): static
    {
        return $this->whereTyped('dueBefore', $this->formatDate($value), 'ISO8601DateTime');
    }

    /**
     * Only find tasks with associated Orders that do not have one of these statuses
     */
    public function excludedOrderStatusIds(array $value): static
    {
        return $this->whereTyped('excludedOrderStatusIds', $value, '[ID!]');
    }

    /**
     * Only find tasks with associated Orders that have one of these statuses
     */
    public function includedOrderStatusIds(array $value): static
    {
        return $this->whereTyped('includedOrderStatusIds', $value, '[ID!]');
    }

    /**
     * Which field to sort Tasks on
     */
    public function sortOn(TaskSortField $value): static
    {
        return $this->whereTyped('sortOn', $value->value, 'TaskSortField');
    }

    /**
     * Should the sort be descending?
     */
    public function sortDescending(bool $value): static
    {
        return $this->whereTyped('sortDescending', $value, 'Boolean');
    }
}
