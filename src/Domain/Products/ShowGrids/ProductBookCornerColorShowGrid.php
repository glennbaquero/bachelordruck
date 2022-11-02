<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBookCornerColorFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductBookCornerColorShowGrid
{
    private string $modelName = 'ProductBookCornerColor';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: ProductBookCornerColorFieldEnum::ID),
                $fieldCreator->text(field: ProductBookCornerColorFieldEnum::TITLE),
                $fieldCreator->color(field: ProductBookCornerColorFieldEnum::COLOR),
                $fieldCreator->checkbox(field: ProductBookCornerColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(field: ProductBookCornerColorFieldEnum::SORT),
                $fieldCreator->enum(field: ProductBookCornerColorFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
