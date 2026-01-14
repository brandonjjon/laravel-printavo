<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\PresetTaskGroup;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for PresetTaskGroup resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class PresetTaskGroupMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'presetTaskGroup';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<PresetTaskGroup>
     */
    protected string $dataClass = PresetTaskGroup::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
