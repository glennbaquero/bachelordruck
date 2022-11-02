<?php

namespace Support\Helpers;

use Illuminate\Support\Carbon;
use Support\Traits\Locale;

class Date
{
    use Locale;

    public const DE = 'd.m.y';

    public const EN = 'm-d-Y';

    public function __invoke($value): string
    {
        $locale = $this->getLocale();
        $date = Carbon::createFromFormat('Y-m-d', $value);

        if ($locale === 'de_DE') {
            return $date->format(self::DE);
        }

        return $date->format(self::EN);
    }

    public static function format($value): string
    {
        $self = new self();

        return $self($value);
    }

    public static function parseYear($yearRange): array
    {
        return explode('-', $yearRange);
    }

    public static function getFormat(): string
    {
        $locale = (new static())->getLocale();

        if ($locale === 'de_DE') {
            return self::DE;
        }

        return self::EN;
    }
}
