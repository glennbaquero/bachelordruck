<?php

namespace Domain\Orders\Enums;

use App\Traits\EnumSelectable;

enum PaymentEnum: string
{
    use EnumSelectable;

    case PAYPAL = 'paypal';
    case CASH = 'cash';
    case CARD = 'card';
    case BANK = 'bank';
    case PAYMENT_IN_ADVANCE = 'payment_in_advance';
}
