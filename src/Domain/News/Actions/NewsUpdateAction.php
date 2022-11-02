<?php

namespace Domain\News\Actions;

use Domain\News\DataTransferObjects\NewsData;
use Domain\News\Models\News;

class NewsUpdateAction
{
    public function __invoke(News $news, NewsData $newsData): News
    {
        $news->fill([
            'language_id' => $newsData->language_id,
            'title' => $newsData->title,
            'slug' => $newsData->slug,
            'description' => $newsData->description,
            'video_url' => $newsData->video_url ?? null,
            'news_date' => $newsData->news_date,
            'status' => $newsData->status,
        ])->save();

        return $news->refresh();
    }
}
