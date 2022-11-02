<?php

namespace Domain\Galleries\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum GalleryFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case LANGUAGE_ID = 'language_id';
    case PAGE_ID = 'page_id';
    case TITLE = 'title';
    case DESCRIPTION = 'description';
    case STATUS = 'status';
    case SORT = 'sort';
    case IMAGE = 'image';
    case IMAGES = 'images';
    case SLUG = 'slug';
    case PDF = 'pdf';

    public function payload(): array
    {
        return [];
    }
}
