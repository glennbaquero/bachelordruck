<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverImprintColorFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductCoverImprintColorShowGrid
{
    private string $modelName = 'productCoverImprintColor';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: ProductCoverImprintColorFieldEnum::ID),
                $fieldCreator->text(field: ProductCoverImprintColorFieldEnum::TITLE),
                $fieldCreator->color(field: ProductCoverImprintColorFieldEnum::COLOR),
                $fieldCreator->checkbox(field: ProductCoverImprintColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(field: ProductCoverImprintColorFieldEnum::SORT),
                $fieldCreator->enum(field: ProductCoverImprintColorFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
