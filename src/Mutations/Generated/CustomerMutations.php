<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Customer;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Customer resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class CustomerMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'customer';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Customer>
     */
    protected string $dataClass = Customer::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
