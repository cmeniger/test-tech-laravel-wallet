<?php

declare(strict_types=1);

namespace App\Enums;

enum RecurringTransferStatus: string
{
    case VALID = 'valid';
    case ERROR = 'error';
    case LOW_BALANCE = 'low_balance';
}
