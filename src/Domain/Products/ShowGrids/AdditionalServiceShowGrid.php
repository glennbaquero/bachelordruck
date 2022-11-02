<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\AdditionalServiceFieldEnum;
use Support\Creators\OutputFieldCreator;

class AdditionalServiceShowGrid
{
    private string $modelName = 'additionalService';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: AdditionalServiceFieldEnum::ID),
                $fieldCreator->text(field: AdditionalServiceFieldEnum::TITLE),
                $fieldCreator->text(field: AdditionalServiceFieldEnum::TOOLTIP),
                $fieldCreator->decimal(field: AdditionalServiceFieldEnum::SURCHARGE),
                $fieldCreator->decimal(field: AdditionalServiceFieldEnum::SORT),
                $fieldCreator->enum(field: AdditionalServiceFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
