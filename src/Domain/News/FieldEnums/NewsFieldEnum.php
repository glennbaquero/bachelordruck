<?php

namespace Domain\News\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum NewsFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case LANGUAGE_ID = 'language_id';
    case DESCRIPTION = 'description';
    case SLUG = 'slug';
    case VIDEO_URL = 'video_url';
    case TITLE = 'title';
    case STATUS = 'status';
    case NEWS_DATE = 'news_date';
    case IMAGE = 'image';
    case IMAGES = 'images';
    case PDF = 'pdf';

    public function payload(): array
    {
        return [];
    }
}
