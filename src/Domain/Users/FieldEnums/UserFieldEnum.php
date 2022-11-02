<?php

namespace Domain\Users\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum UserFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case NAME = 'name';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case INITIALS = 'initials';
    case COLOR = 'color';
    case AVATAR = 'avatar';

    public function payload(): array
    {
        return [];
    }
}
