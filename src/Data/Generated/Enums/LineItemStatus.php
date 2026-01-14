<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Line item statuses
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum LineItemStatus: string
{
    case NeedOrdering = 'need_ordering';
    case AttachedToPo = 'attached_to_po';
    case Ordered = 'ordered';
    case Arrived = 'arrived';
    case PartiallyReceived = 'partially_received';
    case Received = 'received';
    case In = 'in';
}
