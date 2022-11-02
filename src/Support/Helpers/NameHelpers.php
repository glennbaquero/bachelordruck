<?php

namespace Support\Helpers;

use Illuminate\Support\Str;

class NameHelpers
{
    public static function getInitials(string $fullName): string
    {
        $parts = explode(' ', $fullName);
        $initials = '';

        foreach ($parts as $part) {
            if (isset($part[0])) {
                $initials .= $part[0];
            }
        }

        if (Str::length($initials) < 2) {
            $initials = Str::substr($fullName, 0, 2);
        }

        return Str::of($initials)->upper()->substr(0, 3);
    }
}
