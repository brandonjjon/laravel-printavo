<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Purchase order line item status
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum PoGoodsStatus: string
{
    case NotOrdered = 'not_ordered';
    case Ordered = 'ordered';
    case Arrived = 'arrived';
    case PartiallyReceived = 'partially_received';
    case Received = 'received';
}
