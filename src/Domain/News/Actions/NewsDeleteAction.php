<?php

namespace Domain\News\Actions;

use Domain\News\Models\News;

class NewsDeleteAction
{
    public function __invoke(News $news): void
    {
        $news->delete();
    }
}
