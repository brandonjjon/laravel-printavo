<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Product;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for products collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ProductsBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'products';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'product';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Product>
     */
    protected string $dataClass = Product::class;

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
        $this->selects = Product::defaultFields();
    }

    /**
     * Product search term
     */
    public function query(string $value): static
    {
        return $this->whereTyped('query', $value, 'String');
    }
}
