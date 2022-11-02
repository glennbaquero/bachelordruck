<?php

namespace Domain\Products\Enums;

use App\Traits\EnumSelectable;

enum ProductBindingEnum: string
{
    use EnumSelectable;

    case HARDCOVER = 'hardcover';
    case PLASTIC_SPIRAL = 'plastic_spiral';
    case PERFECT = 'perfect';
}
