<?php

namespace Support\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use NumberFormatter;
use Support\Traits\Locale;

class Decimals
{
    use Locale;

    /**
     * @throws Exception
     */
    public function __invoke($value, $hideFractionIfZero = false): string
    {
        if (! is_float($value)) {
            throw new \RuntimeException('Invalid argument!');
        }

        $fractionDigits = 2;

        if ($hideFractionIfZero) {
            $fraction = round($value - ((int) $value), $fractionDigits);

            if ($fraction === 0.0) {
                $fractionDigits = 0;
            } else {
                $fractionParts = explode('.', $fraction);

                $fractionDigits = strlen($fractionParts[1]);
            }
        }

        $locale = $this->getLocale();

        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);

        return $formatter->format($value);
    }

    /**
     * @throws Exception
     */
    public static function format(float $value, bool $hideFractionIfZero = false): string
    {
        return (new static())($value, $hideFractionIfZero);
    }

    /**
     * @throws Exception
     */
    public static function formatAsAttribute(mixed $value, bool $hideFractionIfZero = false): Attribute
    {
        return Attribute::get(function () use ($value, $hideFractionIfZero) {
            return self::format((float) $value, $hideFractionIfZero);
        });
    }
}
