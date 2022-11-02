<?php

namespace Domain\Banners\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum BannerFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PAGE_ID = 'page_id';
    case LANGUAGE_ID = 'language_id';
    case TRANSMISSION = 'transmission';
    case TITLE = 'title';
    case DESCRIPTION = 'description';
    case URL = 'url';
    case LINK_TEXT = 'link_text';
    case SORT = 'sort';
    case STATUS = 'status';
    case CREATED_AT = 'created_at';
    case UPDATED_AT = 'updated_at';
    case IMAGE = 'image';

    public function payload(): array
    {
        return [];
    }
}
