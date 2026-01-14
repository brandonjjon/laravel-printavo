<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Transaction;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for transactions collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class TransactionsBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'transactions';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'transaction';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Transaction>
     */
    protected string $dataClass = Transaction::class;

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
        $this->selects = Transaction::defaultFields();
    }
}
