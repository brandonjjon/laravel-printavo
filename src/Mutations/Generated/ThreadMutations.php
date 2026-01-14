<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Thread;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Thread resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ThreadMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'thread';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Thread>
     */
    protected string $dataClass = Thread::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
