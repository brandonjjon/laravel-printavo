<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Which field to sort on
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum ContactSortField: string
{
    case CustomerName = 'CUSTOMER_NAME';
    case ContactName = 'CONTACT_NAME';
    case ContactEmail = 'CONTACT_EMAIL';
    case OrderCount = 'ORDER_COUNT';
}
