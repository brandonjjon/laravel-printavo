<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Mockup;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Mockup resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class MockupMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'mockup';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Mockup>
     */
    protected string $dataClass = Mockup::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
