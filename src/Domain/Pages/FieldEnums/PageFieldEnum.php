<?php

namespace Domain\Pages\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum PageFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case PARENT_ID = 'parent_id';

    public function payload(): array
    {
        return match ($this) {
            default => [],
        };
    }
}
