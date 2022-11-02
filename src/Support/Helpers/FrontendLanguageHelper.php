<?php

namespace Support\Helpers;

use Domain\Pages\Models\Language;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FrontendLanguageHelper
{
    protected Language $language;

    protected Collection $pageLanguages;

    public function setLanguage(): void
    {
        $this->language = $this->get();
    }

    public function get()
    {
        $defaultLanguage = $this->getDefaultLanguage();

        if (($firstSegment = $this->getFirstSegment()) && $this->isFirstSegmentTwoCharsOnly()) {
            $segmentLanguage = $this->getLanguage($firstSegment);
        }

        return  $segmentLanguage ?? $defaultLanguage;
    }

    protected function getDefaultLanguage()
    {
        return Cache::remember('default-language', now()->addMinutes(10), function () {
            return Language::first();
        });
    }

    protected function getFirstSegment(): ?string
    {
        return request()->segment(1, null);
    }

    protected function isFirstSegmentTwoCharsOnly(): bool
    {
        return strlen(request()->segment(1)) === 2;
    }

    protected function getLanguage($languageCode)
    {
        return Cache::remember('language-'.$languageCode, now()->addMinutes(10), function () use ($languageCode) {
            return Language::where('languageCode', $languageCode)->first();
        });
    }

    protected function getUrlExceptLanguageSegment()
    {
        $segments = request()->segments();
        unset($segments[0]);

        return '/'.implode('/', $segments);
    }

    public function translateCurrentUrlTo($languageCode)
    {
        try {
            $url = $this->getUrlExceptLanguageSegment();
            $language = $this->getLanguage($languageCode);
            $pageLanguage = $this->getPageLanguages()->where('url', $url)->first();

            return '/'.$languageCode.$pageLanguage->page->pagesLanguage->where('language_id', $language->id)->first()->url;
        } catch (\Throwable $e) {
            return '/'.$languageCode;
        }
    }

    public function translateUrlToCurrentLanguage($name): string
    {
        $this->setLanguage();

        return '/'.$this->language->languageCode.$this->getPageLanguage($name)?->url;
    }

    public function translateCurrentLanguageName($name): ?string
    {
        $this->setLanguage();

        return $this->getPageLanguage($name)?->name ?? $name;
    }

    private function getPageLanguage(string $name): ?Model
    {
        return cache()
            ->store('array')
            ->rememberForever('page-language-temp-'.$name, function () use ($name) {
                $pageLanguage = $this->getPageLanguages()
                    ->where('name', $name)
                    ->first();

                if (! $pageLanguage) {
                    return null;
                }

                return $pageLanguage
                    ->page
                    ->pagesLanguage
                    ->where('language_id', $this->language->id)
                    ->first();
            });
    }

    private function getPageLanguages()
    {
        return cache()
            ->remember('page-languages', now()->addMinutes(1), function () {
                return PageLanguage::with('page.pagesLanguage')->get();
            });
    }
}
