<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\LineItemGroup;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for LineItemGroup resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class LineItemGroupMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'lineItemGroup';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<LineItemGroup>
     */
    protected string $dataClass = LineItemGroup::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
