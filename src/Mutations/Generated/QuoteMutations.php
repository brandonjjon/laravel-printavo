<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Quote;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Quote resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class QuoteMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'quote';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Quote>
     */
    protected string $dataClass = Quote::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
