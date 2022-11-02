<?php

namespace Domain\Pages\Collections;

use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PageLanguageCollection extends Collection
{
    public function selectOptions(): Collection|PageLanguageCollection|\Illuminate\Support\Collection
    {
        return $this->transform(function (Model $pageLanguage) {
            $pageLanguage->makeHidden([
                ...['language'],
                ...array_keys($pageLanguage->getAttributes()),
            ]);

            $pageLanguage->name = $pageLanguage->getNameWithLanguageCode();

            $pageLanguage->makeVisible([
                'id',
                'name',
            ]);

            return $pageLanguage;
        });
    }

    /**
     * @param  string  $pageLanguageName
     * @return Collection|PageLanguageCollection|\Illuminate\Support\Collection
     */
    public function navigationItems(string $pageLanguageName, array $excludes = ['/']): Collection|PageLanguageCollection|\Illuminate\Support\Collection
    {
        $cacheKey = 'page_language_'.Str::snake($pageLanguageName);
        $pageIds = cache()->rememberForever($cacheKey, function () use ($pageLanguageName) {
            $pageLanguage = PageLanguage::query()
                ->where('name', $pageLanguageName)
                ->first();

            if (! $pageLanguage) {
                return collect();
            }

            return Page::descendantsOf($pageLanguage->page_id)->pluck('id')->all();
        });

        return $this->whereIn('page_id', $pageIds)
            ->where('visible', 1)
            ->whereNotInStrict('url', $excludes)
            ->values();
    }
}
