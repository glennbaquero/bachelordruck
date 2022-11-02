<?php

namespace Domain\Pages\Enums;

use App\Traits\EnumSelectable;

enum TargetTypeEnum: string
{
    use EnumSelectable;

    case CONTENT = 'content';
    case INTERNAL_LINK = 'internal_link';
}
