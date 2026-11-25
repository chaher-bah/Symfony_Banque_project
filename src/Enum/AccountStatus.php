<?php

namespace App\Enum;

enum AccountStatus: string
{
    case PENDING = 'PENDING';
    case ACTIVE = 'ACTIVE';
    case FROZEN = 'FROZEN';
    case CLOSED = 'CLOSED';
}
