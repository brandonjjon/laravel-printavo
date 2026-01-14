<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Status of an approval request
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum ApprovalRequestStatus: string
{
    case Approved = 'approved';
    case Declined = 'declined';
    case Pending = 'pending';
    case Revoked = 'revoked';
    case Unapproved = 'unapproved';
}
