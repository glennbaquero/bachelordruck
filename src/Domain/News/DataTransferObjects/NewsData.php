<?php

namespace Domain\News\DataTransferObjects;

use App\Enums\StatusEnum;
use Domain\News\Models\News;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class NewsData extends DataTransferObject
{
    public int $language_id;

    public string $title;

    public string $slug;

    public string $description;

    public ?string $video_url;

    public string $news_date;

    public StatusEnum $status;

    public static function fromModel(News $news): NewsData
    {
        return new self(
            language_id: $news->language_id,
            title: $news->title,
            slug: $news->slug ?? Str::slug($news->title),
            description: $news->description,
            video_url: $news->video_url,
            news_date: $news->news_date,
            status: StatusEnum::from($news->status->value ?? $news->status),
        );
    }
}
