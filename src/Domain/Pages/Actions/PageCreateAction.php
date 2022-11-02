<?php

namespace Domain\Pages\Actions;

use Domain\Pages\DataTransferObjects\PageData;
use Domain\Pages\Models\Page;

class PageCreateAction
{
    public function __invoke(PageData $pageData): Page
    {
        return Page::create([
            'parent_id' => $pageData->parent_id,
        ]);
    }
}
