<?php

namespace App\Enums;

use App\Traits\EnumSelectable;

enum SalutationEnum: string
{
    use EnumSelectable;

    case MR = 'mr';
    case MRS = 'mrs';
}
