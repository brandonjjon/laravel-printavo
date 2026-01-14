<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\PaymentTerm;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for PaymentTerm resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class PaymentTermMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'paymentTerm';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<PaymentTerm>
     */
    protected string $dataClass = PaymentTerm::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
