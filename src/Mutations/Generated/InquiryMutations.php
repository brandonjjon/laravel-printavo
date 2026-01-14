<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Inquiry;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Inquiry resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class InquiryMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'inquiry';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Inquiry>
     */
    protected string $dataClass = Inquiry::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
