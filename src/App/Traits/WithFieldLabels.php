<?php

namespace App\Traits;

use Support\Helpers\FilenameHelpers;

trait WithFieldLabels
{
    public static function labels(): array
    {
        $labels = [];
        $langPrefix = lcfirst(FilenameHelpers::getClassShortName(self::class)->replace('Enum', '')->plural());
        foreach (self::cases() as $case) {
            $labels[$case->value] = __($langPrefix.'.'.$case->value);
        }

        return $labels;
    }
}
