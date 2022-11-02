<?php

namespace Domain\Pages\Actions;

use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\Models\PageLanguage;

class PageLanguageUpdateAction
{
    public function __invoke(PageLanguage $pageLanguage, PageLanguageData $pageLanguageData): PageLanguage
    {
        $pageLanguage->fill([
            'url' => $pageLanguageData->url,
            'target_type' => $pageLanguageData->target_type,
            'name' => $pageLanguageData->name,
            'title' => $pageLanguageData->title,
            'layout' => $pageLanguageData->layout_id,
            'description' => $pageLanguageData->description,
            'active' => $pageLanguageData->active,
            'visible' => $pageLanguageData->visible,
        ])->save();

        return $pageLanguage->refresh();
    }
}
