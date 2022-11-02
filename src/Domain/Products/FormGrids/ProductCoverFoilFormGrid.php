<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverFoilFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductCoverFoilFormGrid
{
    private string $modelName = 'productCoverFoil';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductCoverFoilFieldEnum::TITLE),
                $fieldCreator->checkbox(ProductCoverFoilFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductCoverFoilFieldEnum::SORT),
                $fieldCreator->select(ProductCoverFoilFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
                $fieldCreator->upload(ProductCoverFoilFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image'),
            ]),
        ];
    }
}
