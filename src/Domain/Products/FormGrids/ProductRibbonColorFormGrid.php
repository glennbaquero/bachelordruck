<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductRibbonColorFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductRibbonColorFormGrid
{
    private string $modelName = 'productRibbonColor';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductRibbonColorFieldEnum::TITLE),
                $fieldCreator->color(ProductRibbonColorFieldEnum::COLOR),
                $fieldCreator->checkbox(ProductRibbonColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductRibbonColorFieldEnum::SORT),
                $fieldCreator->select(ProductRibbonColorFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
