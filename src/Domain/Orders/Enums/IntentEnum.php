<?php

namespace Domain\Orders\Enums;

use App\Traits\EnumSelectable;

enum IntentEnum: string
{
    use EnumSelectable;

    case CAPTURE = 'CAPTURE';
    case AUTHORIZED = 'AUTHORIZED';
}
