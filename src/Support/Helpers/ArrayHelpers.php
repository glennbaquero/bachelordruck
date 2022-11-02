<?php

namespace Support\Helpers;

class ArrayHelpers
{
    public static function keyPrepend(array $array, string $prependString, string $skip = null): array
    {
        return array_combine(
            array_map(static function ($key) use ($prependString, $skip) {
                if ($key === $skip) {
                    return $key;
                }

                return $prependString.$key;
            }, array_keys($array)),
            $array
        );
    }

    public static function parsePipe($pipeRange)
    {
        return explode('-', $pipeRange);
    }
}
