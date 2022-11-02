<?php

namespace Domain\Users\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class PasswordRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'name' => 'string',
            'email' => 'string',
            'new_password' => [
                'required',
                new Password(),
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'user.');
    }
}
