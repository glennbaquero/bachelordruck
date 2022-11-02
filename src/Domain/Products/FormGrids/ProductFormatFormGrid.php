<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductFormatFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductFormatFormGrid
{
    private string $modelName = 'productFormat';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductFormatFieldEnum::PRODUCT_TITLE, readonly: true),
                $fieldCreator->text(ProductFormatFieldEnum::TITLE),
                $fieldCreator->checkbox(ProductFormatFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductFormatFieldEnum::SORT),
                $fieldCreator->select(ProductFormatFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
