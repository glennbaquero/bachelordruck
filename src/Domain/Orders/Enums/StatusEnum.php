<?php

namespace Domain\Orders\Enums;

use App\Traits\EnumSelectable;

enum StatusEnum: string
{
    use EnumSelectable;

    case WAITING_FOR_PAYMENT = 'waiting for payment';
    case READY_FOR_PRODUCTION = 'ready for production';
    case IN_PRODUCTION = 'in production';
    case FINISHED = 'finished';
}
