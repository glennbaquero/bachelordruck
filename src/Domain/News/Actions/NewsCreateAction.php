<?php

namespace Domain\News\Actions;

use Domain\News\DataTransferObjects\NewsData;
use Domain\News\Models\News;

class NewsCreateAction
{
    public function __invoke(NewsData $newsData): News
    {
        return News::create([
            'language_id' => $newsData->language_id,
            'title' => $newsData->title,
            'slug' => $newsData->slug,
            'description' => $newsData->description,
            'video_url' => $newsData->video_url ?? null,
            'news_date' => $newsData->news_date,
            'status' => $newsData->status,
        ]);
    }
}
