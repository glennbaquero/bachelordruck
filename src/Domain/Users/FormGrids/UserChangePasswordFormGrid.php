<?php

namespace Domain\Users\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Users\FieldEnums\UserFieldEnum;
use Support\Creators\FormFieldCreator;

class UserChangePasswordFormGrid
{
    private string $modelName = 'user';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(title: __('Change Password'), fields: [
                $fieldCreator->text(UserFieldEnum::NAME, readonly: true),
                $fieldCreator->email(UserFieldEnum::EMAIL, readonly: true),
                $fieldCreator->password('new_password', autofocus: true),
            ]),
        ];
    }
}
