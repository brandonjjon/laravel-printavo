<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Fee;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Fee resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class FeeMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'fee';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Fee>
     */
    protected string $dataClass = Fee::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
