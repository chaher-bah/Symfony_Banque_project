<?php

namespace App\Enum;

enum UserStatus: string
{
    case PENDING = 'PENDING';
    case ACTIVE = 'ACTIVE';
    case REJECTED = 'REJECTED';
}
