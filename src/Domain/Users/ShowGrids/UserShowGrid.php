<?php

namespace Domain\Users\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Users\FieldEnums\UserFieldEnum;
use Support\Creators\OutputFieldCreator;

class UserShowGrid
{
    private string $modelName = 'user';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->user(field: UserFieldEnum::ID, label: 'User XYZ-custom label'),
                $fieldCreator->text(field: UserFieldEnum::NAME),
                $fieldCreator->email(field: UserFieldEnum::EMAIL),
                $fieldCreator->text(field: UserFieldEnum::INITIALS),
                $fieldCreator->color(field: UserFieldEnum::COLOR),
            ]),
        ];
    }
}
