<?php

namespace Domain\Pages\Services;

use Domain\Pages\Collections\PageLanguageCollection;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;

class PageLanguageServices
{
    public function getSelectOptions(): array|Collection|PageLanguageCollection
    {
        return PageLanguage::query()
            ->with('language')
            ->whereHas('containers')
            ->orderBy('name')
            ->get();
    }

    public function getPageLanguages(Language $language): Collection|array
    {
        return PageLanguage::query()
            ->with('language')
            ->whereBelongsTo($language)
            ->get();
    }
}
