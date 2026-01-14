<?php

namespace Brandonjjon\Printavo\Query;

use ArrayIterator;
use Brandonjjon\Printavo\Data\BaseData;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, BaseData>
 */
readonly class Paginator implements Countable, IteratorAggregate
{
    /**
     * Create a new paginator instance.
     *
     * @param  array<int, BaseData>  $items  The current page of DTO instances
     * @param  ?string  $cursor  The cursor for the next page (null if no more pages)
     * @param  bool  $hasMorePages  Whether there are more pages available
     * @param  int  $perPage  The number of items per page
     */
    public function __construct(
        public array $items,
        public ?string $cursor,
        public bool $hasMorePages,
        public int $perPage,
    ) {}

    /**
     * Get the cursor for the next page.
     */
    public function getNextCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Check if there are more pages available.
     */
    public function hasMorePages(): bool
    {
        return $this->hasMorePages;
    }

    /**
     * Get all items on the current page.
     *
     * @return array<int, BaseData>
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * Count the number of items on the current page.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return Traversable<int, BaseData>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Check if the paginator is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if the paginator has items.
     */
    public function isNotEmpty(): bool
    {
        return ! empty($this->items);
    }
}
