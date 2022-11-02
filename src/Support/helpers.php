<?php

use Support\Helpers\Decimals;

if (! function_exists('decimals')) {
    /**
     * @param $value
     */
    function decimals($value)
    {
        $decimals = new Decimals();

        return $decimals($value);
    }
}
