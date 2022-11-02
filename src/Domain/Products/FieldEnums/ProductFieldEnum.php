<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case SLUG = 'slug';
    case TITLE = 'title';
    case TOOLTIP = 'tooltip';
    case DESCRIPTION = 'description';
    case PRICE = 'price';
    case HAS_COVER_COLOR = 'has_cover_color';
    case HAS_COVER_IMPRINT_COLOR = 'has_cover_imprint_color';
    case HAS_COVER_FOIL = 'has_cover_foil';
    case HAS_BACK_COVER = 'has_back_cover';
    case HAS_BOOK_SPINE_LABEL = 'has_book_spine_label';
    case BOOK_SPINE_LABEL_SURCHARGE = 'book_spine_label_surcharge';
    case HAS_BOOK_CORNERS = 'has_book_corners';
    case BOOK_CORNERS_SURCHARGE = 'book_corners_surcharge';
    case HAS_RIBBON = 'has_ribbon';
    case RIBBON_SURCHARGE = 'ribbon_surcharge';
    case SORT = 'sort';
    case STATUS = 'status';
    case IMAGE = 'image';

    public function payload(): array
    {
        return [];
    }
}
