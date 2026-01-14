<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Status;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Status resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class StatusMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'status';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Status>
     */
    protected string $dataClass = Status::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
