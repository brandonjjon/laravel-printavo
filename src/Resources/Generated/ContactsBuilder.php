<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Contact;
use Brandonjjon\Printavo\Data\Generated\Enums\ContactSortField;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for contacts collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ContactsBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'contacts';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'contact';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Contact>
     */
    protected string $dataClass = Contact::class;

    /**
     * The fields to select.
     *
     * @var array<string>
     */
    protected array $selects = [];

    /**
     * Create a new builder instance.
     */
    public function __construct(PrintavoClient $client)
    {
        parent::__construct($client);
        $this->selects = Contact::defaultFields();
    }

    /**
     * Only search primary contacts?
     */
    public function primaryOnly(bool $value): static
    {
        return $this->whereTyped('primaryOnly', $value, 'Boolean');
    }

    /**
     * Query string
     */
    public function query(string $value): static
    {
        return $this->whereTyped('query', $value, 'String');
    }

    /**
     * Should the sort be descending?
     */
    public function sortDescending(bool $value): static
    {
        return $this->whereTyped('sortDescending', $value, 'Boolean');
    }

    /**
     * Sort on this field
     */
    public function sortOn(ContactSortField $value): static
    {
        return $this->whereTyped('sortOn', $value->value, 'ContactSortField');
    }
}
