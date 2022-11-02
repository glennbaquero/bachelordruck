<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;

class UserDeleteAction
{
    public function __invoke(User $user): void
    {
        $user->delete();
    }
}
