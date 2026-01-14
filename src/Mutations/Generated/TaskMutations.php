<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Task;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Task resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class TaskMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'task';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Task>
     */
    protected string $dataClass = Task::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
