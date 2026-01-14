<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\ProductionFile;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for ProductionFile resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ProductionFileMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'productionFile';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<ProductionFile>
     */
    protected string $dataClass = ProductionFile::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
