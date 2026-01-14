<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\TransactionPayment;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for TransactionPayment resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class TransactionPaymentMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'transactionPayment';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<TransactionPayment>
     */
    protected string $dataClass = TransactionPayment::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
