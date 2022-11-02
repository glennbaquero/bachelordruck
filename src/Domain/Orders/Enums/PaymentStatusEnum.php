<?php

namespace Domain\Orders\Enums;

use App\Traits\EnumSelectable;

enum PaymentStatusEnum: string
{
    use EnumSelectable;

    case CREATED = 'CREATED';
    case SAVED = 'SAVED';
    case APPROVED = 'APPROVED';
    case VOIDED = 'VOIDED';
    case COMPLETED = 'COMPLETED';
    case PAYMENT_ACTION_REQUIRED = 'PAYMENT_ACTION_REQUIRED';
}
