<?php

namespace Support\Castables;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class IntegerCurrency implements Castable
{
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class() implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes): float|int
            {
                return $value / 100;
            }

            public function set($model, $key, $value, $attributes): float|int
            {
                return (int) ($value * 100);
            }
        };
    }
}
