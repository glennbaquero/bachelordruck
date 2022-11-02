<?php

namespace App\Enums;

use App\Traits\EnumSelectable;

enum StatusEnum: string
{
    use EnumSelectable;

    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
