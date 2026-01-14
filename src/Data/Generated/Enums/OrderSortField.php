<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Which column to sort on
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum OrderSortField: string
{
    case CustomerDueAt = 'CUSTOMER_DUE_AT';
    case CustomerName = 'CUSTOMER_NAME';
    case Status = 'STATUS';
    case Owner = 'OWNER';
    case Total = 'TOTAL';
    case VisualId = 'VISUAL_ID';
}
