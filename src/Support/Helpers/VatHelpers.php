<?php

namespace Support\Helpers;

class VatHelpers
{
    public static function computeNet(float $grossAmount, float $vatRateInDecimal): float
    {
        return round(($grossAmount / (1 + $vatRateInDecimal)), 0, PHP_ROUND_HALF_UP);
    }

    public static function computeGross(float $amount, float $vatRateInDecimal): float
    {
        return round($amount + ($amount * $vatRateInDecimal), 2, PHP_ROUND_HALF_UP);
    }
}
