<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Support\Helpers\NameHelpers;

class UserUpdateAction
{
    public function __invoke(User $user, UserData $userData): User
    {
        $user->name = $userData->name;
        $user->email = $userData->email;
        $user->initials = $userData->initials ?: NameHelpers::getInitials($userData->name);

        $user->save();

        return $user->refresh();
    }
}
