<?php

namespace Domain\Pages\Actions;

use Domain\Pages\Models\Page;

class PageDeleteAction
{
    public function __invoke(Page $page): void
    {
        $page->delete();
    }
}
