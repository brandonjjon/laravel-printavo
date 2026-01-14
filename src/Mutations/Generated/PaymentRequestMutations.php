<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\PaymentRequest;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for PaymentRequest resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class PaymentRequestMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'paymentRequest';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<PaymentRequest>
     */
    protected string $dataClass = PaymentRequest::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
