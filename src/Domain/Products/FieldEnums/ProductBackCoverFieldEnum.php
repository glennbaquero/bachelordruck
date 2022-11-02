<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductBackCoverFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case TITLE = 'title';
    case COLOR = 'color';
    case IS_PRESELECTED = 'is_preselected';
    case SORT = 'sort';
    case STATUS = 'status';

    public function payload(): array
    {
        return [];
    }
}
