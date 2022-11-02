<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductFormatFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductFormatShowGrid
{
    private string $modelName = 'productFormat';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: ProductFormatFieldEnum::TITLE),
                $fieldCreator->checkbox(field: ProductFormatFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(field: ProductFormatFieldEnum::SORT),
                $fieldCreator->enum(field: ProductFormatFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
