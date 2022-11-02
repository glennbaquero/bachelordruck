<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductPaperThicknessFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PRODUCT_ID = 'product_id';
    case PRODUCT_TITLE = 'product.title';
    case TITLE = 'title';
    case TOOLTIP = 'tooltip';
    case MAX_PAGES = 'max_pages';
    case PRICE_PER_PAGE_BW = 'price_per_page_bw';
    case PRICE_PER_PAGE_COLOR = 'price_per_page_color';
    case IS_PRESELECTED = 'is_preselected';
    case SORT = 'sort';
    case STATUS = 'status';

    public function payload(): array
    {
        return [];
    }
}
