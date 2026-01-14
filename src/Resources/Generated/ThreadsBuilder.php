<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\ThreadSummary;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for threads collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ThreadsBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'threads';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'thread';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<ThreadSummary>
     */
    protected string $dataClass = ThreadSummary::class;

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
        $this->selects = ThreadSummary::defaultFields();
    }

    /**
     * Only return threads that have unread messages?
     */
    public function onlyWithUnread(bool $value): static
    {
        return $this->whereTyped('onlyWithUnread', $value, 'Boolean');
    }
}
