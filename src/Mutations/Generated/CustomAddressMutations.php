<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\CustomAddress;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for CustomAddress resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class CustomAddressMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'customAddress';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<CustomAddress>
     */
    protected string $dataClass = CustomAddress::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
