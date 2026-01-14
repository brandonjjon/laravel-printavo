<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Imprint;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Imprint resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ImprintMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'imprint';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Imprint>
     */
    protected string $dataClass = Imprint::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
