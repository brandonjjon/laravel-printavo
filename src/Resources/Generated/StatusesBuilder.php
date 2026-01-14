<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Enums\StatusType;
use Brandonjjon\Printavo\Data\Generated\Status;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for statuses collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class StatusesBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'statuses';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'status';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<Status>
     */
    protected string $dataClass = Status::class;

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
        $this->selects = Status::defaultFields();
    }

    /**
     * The type of status
     */
    public function type(StatusType $value): static
    {
        return $this->whereTyped('type', $value->value, 'StatusType');
    }
}
