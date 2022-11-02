<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBackCoverFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductBackCoverShowGrid
{
    private string $modelName = 'ProductBackCover';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->decimal(field: ProductBackCoverFieldEnum::ID),
                $fieldCreator->text(field: ProductBackCoverFieldEnum::TITLE),
                $fieldCreator->color(field: ProductBackCoverFieldEnum::COLOR),
                $fieldCreator->checkbox(field: ProductBackCoverFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(field: ProductBackCoverFieldEnum::SORT),
                $fieldCreator->enum(field: ProductBackCoverFieldEnum::STATUS, enum: StatusEnum::class),
            ]),
        ];
    }
}
