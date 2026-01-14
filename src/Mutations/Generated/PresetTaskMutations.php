<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\PresetTask;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for PresetTask resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class PresetTaskMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'presetTask';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<PresetTask>
     */
    protected string $dataClass = PresetTask::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
