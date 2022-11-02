<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductRibbonColorFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductRibbonColorShowGrid
{
    private string $modelName = 'productRibbonColor';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: ProductRibbonColorFieldEnum::ID),
                $fieldCreator->text(field: ProductRibbonColorFieldEnum::TITLE),
                $fieldCreator->color(field: ProductRibbonColorFieldEnum::COLOR),
                $fieldCreator->checkbox(field: ProductRibbonColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(field: ProductRibbonColorFieldEnum::SORT),
                $fieldCreator->enum(field: ProductRibbonColorFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
