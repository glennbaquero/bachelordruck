<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBookSpineColorFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductBookSpineColorShowGrid
{
    private string $modelName = 'productBookSpineColor';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: ProductBookSpineColorFieldEnum::TITLE),
                $fieldCreator->color(field: ProductBookSpineColorFieldEnum::COLOR),
                $fieldCreator->checkbox(field: ProductBookSpineColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(field: ProductBookSpineColorFieldEnum::SORT),
                $fieldCreator->enum(field: ProductBookSpineColorFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
