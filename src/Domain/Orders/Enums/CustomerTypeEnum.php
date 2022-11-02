<?php

namespace Domain\Orders\Enums;

use App\Traits\EnumSelectable;

enum CustomerTypeEnum: string
{
    use EnumSelectable;

    case PRIVATE = 'private';
    case COMPANY = 'company';
}
