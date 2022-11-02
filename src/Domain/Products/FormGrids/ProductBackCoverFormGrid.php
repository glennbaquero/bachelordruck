<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBackCoverFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductBackCoverFormGrid
{
    private string $modelName = 'ProductBackCover';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductBackCoverFieldEnum::TITLE),
                $fieldCreator->color(ProductBackCoverFieldEnum::COLOR),
                $fieldCreator->checkbox(ProductBackCoverFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductBackCoverFieldEnum::SORT),
                $fieldCreator->select(ProductBackCoverFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
