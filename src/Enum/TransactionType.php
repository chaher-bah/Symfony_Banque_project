<?php

namespace App\Enum;

enum TransactionType: string
{
    case TRANSFER = 'TRANSFER';
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAWAL = 'WITHDRAWAL';
}
