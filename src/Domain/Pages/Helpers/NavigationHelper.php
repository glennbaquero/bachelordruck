<?php

namespace Domain\Pages\Helpers;

use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Support\Str;

class NavigationHelper
{
    protected array $pages;

    public function __construct()
    {
        $this->pages = cache()->remember('page-navigation', now()->addMinutes(10), function () {
            return Page::with([
                'ancestors:id',
                'pagesLanguage',
            ])
            ->get(['id', 'parent_id', '_lft', '_rgt'])->toTree()->toArray();
        });
    }

    public static function getChildrenOfRoot(string $name, int $languageId)
    {
        $navigation = new self();

        return collect($navigation->pages)->filter(function ($item) use ($name) {
            return $item['pages_language'][0]['name'] === $name;
        })->map(function ($page) use ($languageId) {
            $page['children'] = collect($page['children'])->map(function ($child) use ($languageId) {
                $pageLanguage = collect($child['pages_language'])->filter(function ($item) use ($languageId) {
                    return (bool) $item['visible'] &&
                        $item['language_id'] === $languageId &&
                        (bool) $item['active'];
                })->values()->toArray();

                if (count($pageLanguage)) {
                    $child['pages_language'] = $pageLanguage;

                    return $child;
                }
            })->filter(function ($item) {
                return $item;
            })->values()->toArray();

            return $page;
        })->values()->toArray()[0]['children'];
    }

    public static function formatted(string $name, Language $language): array
    {
        $cacheKey = 'navigation_'.Str::snake($name).'_'.$language->languageCode;

        return cache()->rememberForever($cacheKey, function () use ($name, $language) {
            $navigations = self::getChildrenOfRoot($name, $language->id);

            $getPageLanguage = static function (array $pageLanguages) use ($language) {
                $pageLanguage = PageLanguage::hydrate($pageLanguages)->first();
                $pageLanguage->setRelation('language', $language);

                return $pageLanguage;
            };

            $formatted = [];
            foreach ($navigations as $navigation) {
                $pageLanguage = $getPageLanguage($navigation['pages_language']);

                $children = [];
                if (count($navigation['children']) >= 1) {
                    foreach ($navigation['children'] as $child) {
//                        if ($child['pages_language'][0]['active'] === false) {
//                            continue;
//                        }

                        if ($child['pages_language'][0]['visible'] === false) {
                            continue;
                        }

                        $children[] = $getPageLanguage($child['pages_language']);
                    }
                }

                $pageLanguage->children = $children;

                $formatted[] = $pageLanguage;
            }

            return $formatted;
        });
    }
}
