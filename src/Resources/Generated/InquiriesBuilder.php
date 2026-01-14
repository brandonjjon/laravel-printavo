<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Inquiry;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for inquiries collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class InquiriesBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'inquiries';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'inquiry';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Inquiry>
     */
    protected string $dataClass = Inquiry::class;

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
        $this->selects = Inquiry::defaultFields();
    }
}
