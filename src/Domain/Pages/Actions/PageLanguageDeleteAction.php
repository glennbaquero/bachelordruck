<?php

namespace Domain\Pages\Actions;

use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;

class PageLanguageDeleteAction
{
    public function __invoke(PageLanguage $pageLanguage): void
    {
        $page_id = $pageLanguage->page_id;

        $pageLanguage->delete();
        $page = Page::findOrFail($page_id);
        if ($page->pagesLanguage->count() === 1) {
            $page->delete();
        }
    }
}
