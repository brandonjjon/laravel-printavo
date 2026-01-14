<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Status of a payment dispute
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum PaymentDisputeStatusField: string
{
    case DisputeInitiated = 'DISPUTE_INITIATED';
    case RetrievalRequest = 'RETRIEVAL_REQUEST';
    case DisputeInReview = 'DISPUTE_IN_REVIEW';
    case DisputeWon = 'DISPUTE_WON';
    case DisputeLost = 'DISPUTE_LOST';
}
