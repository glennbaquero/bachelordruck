<?php

namespace Domain\Pages\Services;

use Domain\Pages\Collections\PageLanguageCollection;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;

class PageServices
{
    public function getPage(): array|Collection|PageLanguageCollection
    {
        return PageLanguage::query()
            ->with('language')
            ->whereHas('containers')
            ->orderBy('name')
            ->get();
    }
}
