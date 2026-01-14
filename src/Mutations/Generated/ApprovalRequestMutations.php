<?php

namespace Brandonjjon\Printavo\Mutations\Generated;

use Brandonjjon\Printavo\Data\Generated\ApprovalRequest;
use Brandonjjon\Printavo\Mutations\MutationBuilder;

/**
 * Mutation builder for ApprovalRequest resources.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class ApprovalRequestMutations extends MutationBuilder
{
    /**
     * The singular resource name.
     */
    protected string $resource = 'approvalRequest';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<ApprovalRequest>
     */
    protected string $dataClass = ApprovalRequest::class;

    /**
     * The default fields to select in mutation responses.
     *
     * @var array<string>
     */
    protected array $defaultFields = ['id'];
}
