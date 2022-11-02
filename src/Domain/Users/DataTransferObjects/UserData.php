<?php

namespace Domain\Users\DataTransferObjects;

use Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public string $name;

    public string $email;

    public string $initials;

    public ?string $color;

    public ?string $password;

    public static function fromModel(User $user): UserData
    {
        return new self(
            name: $user->name,
            email: $user->email,
            initials: $user->initials ?? '',
            color: $user->color,
            password: Hash::make($user->password ?? 'password'),
        );
    }
}
