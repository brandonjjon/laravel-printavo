<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * The state of a Payment Request
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum PaymentRequestStatus: string
{
    case Open = 'OPEN';
    case Closed = 'CLOSED';
    case Archived = 'ARCHIVED';
}
