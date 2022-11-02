<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum AdditionalServiceFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case TITLE = 'title';
    case TOOLTIP = 'tooltip';
    case SURCHARGE = 'surcharge';
    case SORT = 'sort';
    case STATUS = 'status';

    public function payload(): array
    {
        return [];
    }
}
