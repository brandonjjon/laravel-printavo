<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Invoice;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Invoice resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class InvoiceMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'invoice';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Invoice>
     */
    protected string $dataClass = Invoice::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
