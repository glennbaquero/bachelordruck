<?php

namespace Support\Helpers;

use Domain\Pages\Models\Language;

class UserLanguageSessionHelper
{
    public static function set(string $languageCode): void
    {
        session(['user_language_code' => $languageCode]);
    }

    public static function get(): string
    {
        if (session()->has('user_language_code')) {
            return session('user_language_code');
        }

        $user = auth()->user();
        if ($user->language_id === null) {
            session(['user_language_code' => Language::first()->languageCode]);

            return session('user_language_code');
        }

        session(['user_language_code' => $user->language->languageCode]);

        return session('user_language_code');
    }

    public static function setIfNotEqualToCurrent(string $languageCode)
    {
        if (session('user_language_code') !== $languageCode) {
            self::set($languageCode);
        }
    }
}
