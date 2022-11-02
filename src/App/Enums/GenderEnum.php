<?php

namespace App\Enums;

use App\Traits\EnumSelectable;

enum GenderEnum: string
{
    use EnumSelectable;

    case MALE = 'male';
    case FEMALE = 'female';
    case DIVERSE = 'diverse';
}
