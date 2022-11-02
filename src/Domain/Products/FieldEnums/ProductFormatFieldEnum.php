<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductFormatFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PRODUCT_ID = 'product_id';
    case PRODUCT_TITLE = 'product.title';
    case TITLE = 'title';
    case IS_PRESELECTED = 'is_preselected';
    case SORT = 'sort';
    case STATUS = 'status';

    public function payload(): array
    {
        return [];
    }
}
