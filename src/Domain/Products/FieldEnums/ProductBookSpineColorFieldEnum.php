<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductBookSpineColorFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PRODUCT_ID = 'product_id';
    case PRODUCT_TITLE = 'product.title';
    case TITLE = 'title';
    case COLOR = 'color';
    case IS_PRESELECTED = 'is_preselected';
    case SORT = 'sort';
    case STATUS = 'status';
    case IMAGE = 'image';

    public function payload(): array
    {
        return [];
    }
}
