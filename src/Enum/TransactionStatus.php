<?php

namespace App\Enum;

enum TransactionStatus: string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case REJECTED = 'REJECTED';
}
