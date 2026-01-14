<?php

namespace Brandonjjon\Printavo\Resources\Generated;

use Brandonjjon\Printavo\Data\Generated\Enums\PaymentRequestStatus;
use Brandonjjon\Printavo\Data\Generated\PaymentRequest;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Query\Builder;

/**
 * Query builder for paymentRequests collection.
 *
 * @generated from GraphQL schema - do not edit manually
 */
class PaymentRequestsBuilder extends Builder
{
    /**
     * The GraphQL query name for collections.
     */
    protected string $resource = 'paymentRequests';

    /**
     * The GraphQL query name for single items.
     */
    protected string $singularResource = 'paymentRequest';

    /**
     * The DTO class to hydrate results into.
     *
     * @var class-string<PaymentRequest>
     */
    protected string $dataClass = PaymentRequest::class;

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
        $this->selects = PaymentRequest::defaultFields();
    }

    /**
     * Should the sort be descending?
     */
    public function sortDescending(bool $value): static
    {
        return $this->whereTyped('sortDescending', $value, 'Boolean');
    }

    /**
     * Filter on status
     */
    public function status(PaymentRequestStatus $value): static
    {
        return $this->whereTyped('status', $value->value, 'PaymentRequestStatus');
    }
}
