<?php

namespace Domain\Users\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Users\FieldEnums\UserFieldEnum;
use Support\Creators\FormFieldCreator;

class UserFormGrid
{
    private string $modelName = 'user';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(UserFieldEnum::NAME, defer: false),
                $fieldCreator->text(UserFieldEnum::INITIALS),
                $fieldCreator->email(UserFieldEnum::EMAIL),
                $fieldCreator->color(UserFieldEnum::COLOR),
                $fieldCreator->avatar(UserFieldEnum::AVATAR),
            ]),
        ];
    }
}
