<?php

namespace Domain\Pages\Enums;

use App\Traits\EnumSelectable;

enum ImageAlignmentEnum: string
{
    use EnumSelectable;

    case LEFT = 'left';
    case RIGHT = 'right';
}
