<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\LineItemMockup;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for LineItemMockup resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class LineItemMockupMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'lineItemMockup';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<LineItemMockup>
     */
    protected string $dataClass = LineItemMockup::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
