<?php

namespace Support\Traits;

trait HasSelectOptions
{
    public static function boot()
    {
        parent::boot();

        static::saved(function ($item) {
            cache()->forget(self::selectOptionsCacheName());
        });

        static::deleted(function ($item) {
            cache()->forget(self::selectOptionsCacheName());
        });
    }

    public static function selectOptions(string $orderByColumn = 'name')
    {
        return cache()->rememberForever(self::selectOptionsCacheName(), function () use ($orderByColumn) {
            return (new self())->orderBy($orderByColumn)->get()->toArray();
        });
    }

    public static function selectOptionsCacheName()
    {
        return __CLASS__.'select-options';
    }
}
