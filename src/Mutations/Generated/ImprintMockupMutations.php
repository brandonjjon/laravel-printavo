<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\ImprintMockup;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for ImprintMockup resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ImprintMockupMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'imprintMockup';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<ImprintMockup>
     */
    protected string $dataClass = ImprintMockup::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
