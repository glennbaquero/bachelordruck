<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Support\Helpers\NameHelpers;

class UserCreateAction
{
    public function __invoke(UserData $userData): User
    {
        return User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'initials' => $userData->initials ?: NameHelpers::getInitials($userData->name),
            'color' => $userData->color,
            'password' => $userData->password,
        ]);
    }
}
