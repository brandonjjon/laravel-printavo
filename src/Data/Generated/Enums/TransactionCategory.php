<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
 * The category of the transaction
 *
 * @generated from GraphQL schema - do not edit manually
 */
enum TransactionCategory: string
{
    case BankTransfer = 'BANK_TRANSFER';
    case Cash = 'CASH';
    case Check = 'CHECK';
    case CreditCard = 'CREDIT_CARD';
    case Echeck = 'ECHECK';
    case Other = 'OTHER';
}
