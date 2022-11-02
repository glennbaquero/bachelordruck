<?php

namespace Domain\Pages\Actions;

use Domain\Pages\DataTransferObjects\PageData;
use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\Models\PageLanguage;

class PageLanguageCreateAction
{
    public function __invoke(PageLanguageData $pageLanguageData, PageData $pageData): PageLanguage
    {
        if (empty($pageLanguageData->page_id)) {
            $pageCreateAction = app(PageCreateAction::class);
            $pageLanguageData->page_id = $pageCreateAction($pageData)->id;
        }

        return PageLanguage::create([
            'page_id' => $pageLanguageData->page_id,
            'language_id' => $pageLanguageData->language_id,
            'url' => $pageLanguageData->url,
            'target_type' => $pageLanguageData->target_type,
            'name' => $pageLanguageData->name,
            'title' => $pageLanguageData->title,
            'layout_id' => $pageLanguageData->layout_id,
            'description' => $pageLanguageData->description,
            'active' => $pageLanguageData->active,
            'visible' => $pageLanguageData->visible,
        ]);
    }
}
