<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Customer;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for customers collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class CustomersBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'customers';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'customer';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Customer>
     */
    protected string $dataClass = Customer::class;

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
        $this->selects = Customer::defaultFields();
    }
}
