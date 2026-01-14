<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\EmailMessage;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for EmailMessage resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class EmailMessageMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'emailMessage';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<EmailMessage>
     */
    protected string $dataClass = EmailMessage::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
