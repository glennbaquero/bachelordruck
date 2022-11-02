<?php

namespace Support\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class FilenameHelpers
{
    public static function getClassShortName($class): Stringable
    {
        $reflection = new \ReflectionClass($class);

        return Str::of($reflection->getShortName());
    }
}
