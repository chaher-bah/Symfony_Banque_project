<?php

namespace App\Enum;

enum LoanStatus: string
{
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case ACTIVE = 'ACTIVE';
    case REPAID = 'REPAID';
}
