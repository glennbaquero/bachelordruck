<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverFoilFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductCoverFoilShowGrid
{
    private string $modelName = 'productCoverFoil';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: ProductCoverFoilFieldEnum::ID),
                $fieldCreator->text(field: ProductCoverFoilFieldEnum::TITLE),
                $fieldCreator->checkbox(field: ProductCoverFoilFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(field: ProductCoverFoilFieldEnum::SORT),
                $fieldCreator->enum(field: ProductCoverFoilFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
