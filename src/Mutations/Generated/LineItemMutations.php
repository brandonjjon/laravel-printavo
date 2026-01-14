<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\LineItem;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for LineItem resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class LineItemMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'lineItem';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<LineItem>
     */
    protected string $dataClass = LineItem::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
