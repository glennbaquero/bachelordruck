<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBookCornerColorFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductBookCornerColorFormGrid
{
    private string $modelName = 'ProductBookCornerColor';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductBookCornerColorFieldEnum::TITLE),
                $fieldCreator->color(ProductBookCornerColorFieldEnum::COLOR),
                $fieldCreator->checkbox(ProductBookCornerColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductBookCornerColorFieldEnum::SORT),
                $fieldCreator->select(ProductBookCornerColorFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
