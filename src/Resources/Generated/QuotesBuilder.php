<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Enums\OrderPaymentStatus;
use Brandonjjon\Printavo\Data\Generated\Enums\OrderSortField;
use Brandonjjon\Printavo\Data\Generated\Quote;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for quotes collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class QuotesBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'quotes';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'quote';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Quote>
     */
    protected string $dataClass = Quote::class;

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
        $this->selects = Quote::defaultFields();
    }

    /**
     * Exclude ones with these status IDs
     */
    public function excludeStatusIds(array $value): static
    {
        return $this->whereTyped('excludeStatusIds', $value, '[ID!]');
    }

    /**
     * Find any with a due_date after this date
     */
    public function inProductionAfter(string|\DateTimeInterface $value): static
    {
        return $this->whereTyped('inProductionAfter', $this->formatDate($value), 'ISO8601DateTime');
    }

    /**
     * Find any with a start_date before this date
     */
    public function inProductionBefore(string|\DateTimeInterface $value): static
    {
        return $this->whereTyped('inProductionBefore', $this->formatDate($value), 'ISO8601DateTime');
    }

    /**
     * Find any with this payment status
     */
    public function paymentStatus(OrderPaymentStatus $value): static
    {
        return $this->whereTyped('paymentStatus', $value->value, 'OrderPaymentStatus');
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
    public function sortOn(OrderSortField $value): static
    {
        return $this->whereTyped('sortOn', $value->value, 'OrderSortField');
    }

    /**
     * Only include ones with these status IDs
     */
    public function statusIds(array $value): static
    {
        return $this->whereTyped('statusIds', $value, '[ID!]');
    }

    /**
     * Find any with one of these tags. Ignored if using a query
     */
    public function tags(array $value): static
    {
        return $this->whereTyped('tags', $value, '[String!]');
    }
}
