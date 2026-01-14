<?php

namespace Brandonjjon\Printavo\Contracts;

use Brandonjjon\Printavo\Mutations\MutationResponse;

interface Mutable
{
    /**
     * Execute a create mutation with the current input.
     */
    public function create(): MutationResponse;

    /**
     * Execute an update mutation for the given resource ID.
     */
    public function update(string $id): MutationResponse;

    /**
     * Execute a delete mutation for the given resource ID.
     */
    public function delete(string $id): MutationResponse;
}
