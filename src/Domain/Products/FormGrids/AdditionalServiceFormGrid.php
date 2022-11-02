<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\AdditionalServiceFieldEnum;
use Support\Creators\FormFieldCreator;

class AdditionalServiceFormGrid
{
    private string $modelName = 'additionalService';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(AdditionalServiceFieldEnum::TITLE),
                $fieldCreator->text(AdditionalServiceFieldEnum::TOOLTIP),
                $fieldCreator->decimal(AdditionalServiceFieldEnum::SURCHARGE),
                $fieldCreator->decimal(AdditionalServiceFieldEnum::SORT),
                $fieldCreator->select(AdditionalServiceFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
