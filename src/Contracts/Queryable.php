<?php

namespace Brandonjjon\Printavo\Contracts;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Query\Paginator;
use Illuminate\Support\Collection;

interface Queryable
{
    /**
     * Add a where condition to the query.
     */
    public function where(string $field, mixed $value): static;

    /**
     * Specify fields to select from the query.
     *
     * @param  array<string>|string  $fields
     */
    public function select(array|string $fields): static;

    /**
     * Get the first result matching the query.
     */
    public function first(): ?BaseData;

    /**
     * Get all results matching the query.
     *
     * @return Collection<int, BaseData>
     */
    public function get(): Collection;

    /**
     * Paginate results with cursor-based pagination.
     */
    public function paginate(int $perPage = 25): Paginator;
}
