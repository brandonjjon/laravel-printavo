<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\Contact;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for Contact resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ContactMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'contact';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Contact>
     */
    protected string $dataClass = Contact::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
