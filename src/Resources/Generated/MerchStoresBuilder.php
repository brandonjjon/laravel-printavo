<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\MerchStore;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for merchStores collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class MerchStoresBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'merchStores';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'merchStore';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<MerchStore>
     */
    protected string $dataClass = MerchStore::class;

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
        $this->selects = MerchStore::defaultFields();
    }
}
