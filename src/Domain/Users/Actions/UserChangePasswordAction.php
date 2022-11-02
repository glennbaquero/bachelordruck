<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;

class UserChangePasswordAction
{
    public function __invoke(User $user, string $password): User
    {
        unset($user->new_password);

        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
