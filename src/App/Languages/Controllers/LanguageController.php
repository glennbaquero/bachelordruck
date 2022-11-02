<?php

namespace App\Languages\Controllers;

use Domain\Pages\Models\Language;
use Support\Helpers\UserLanguageSessionHelper;

class LanguageController
{
    public function __invoke($languageCode)
    {
        $language = Language::where('languageCode', $languageCode)->first();
        auth()->user()->language_id = $language->id;
        auth()->user()->save();
        UserLanguageSessionHelper::set($language->languageCode);

        return back();
    }
}
