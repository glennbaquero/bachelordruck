<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductCoverFoilFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case TITLE = 'title';
    case IS_PRESELECTED = 'is_preselected';
    case SORT = 'sort';
    case STATUS = 'status';
    case IMAGE = 'image';

    public function payload(): array
    {
        return [];
    }
}
