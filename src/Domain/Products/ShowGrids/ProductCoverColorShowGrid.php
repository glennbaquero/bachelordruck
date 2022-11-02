<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverColorFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductCoverColorShowGrid
{
    private string $modelName = 'productCoverColor';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: ProductCoverColorFieldEnum::TITLE),
                $fieldCreator->checkbox(field: ProductCoverColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(field: ProductCoverColorFieldEnum::SORT),
                $fieldCreator->enum(field: ProductCoverColorFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
