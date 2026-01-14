<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * The status type
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum MessageDeliveryStatus: string
{
    case Bounced = 'BOUNCED';
    case Clicked = 'CLICKED';
    case Delivered = 'DELIVERED';
    case Error = 'ERROR';
    case Linked = 'LINKED';
    case Opened = 'OPENED';
    case PayFor = 'PAY_FOR';
    case Pending = 'PENDING';
    case Rejected = 'REJECTED';
    case Sent = 'SENT';
    case Other = 'OTHER';
}
