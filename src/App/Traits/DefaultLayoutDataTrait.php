<?php

namespace App\Traits;

use Domain\Pages\Helpers\NavigationHelper;
use Domain\Pages\Models\Language;

trait DefaultLayoutDataTrait
{
    protected function defaultLayoutData(string $languageCode, array $otherData = []): array
    {
        /** @var Language $language */
        $language = cache()->remember($languageCode, now()->addHours(12), function () use ($languageCode) {
            return Language::query()->where('languageCode', $languageCode)->first();
        });

        return [
            ...$otherData,
            'mainNavigation' => NavigationHelper::formatted('Main Navigation', $language),
            'footerNavigation' => NavigationHelper::formatted('Footer Navigation', $language),
        ];
    }
}
