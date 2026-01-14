<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * Payment status of quotes/invoices desired
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum OrderPaymentStatus: string
{
    case Unpaid = 'UNPAID';
    case PartialPayment = 'PARTIAL_PAYMENT';
    case Paid = 'PAID';
}
