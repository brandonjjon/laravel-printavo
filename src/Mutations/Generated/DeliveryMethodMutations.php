<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\DeliveryMethod;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for DeliveryMethod resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class DeliveryMethodMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'deliveryMethod';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<DeliveryMethod>
     */
    protected string $dataClass = DeliveryMethod::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
