<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductBookSpineColorFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductBookSpineColorFormGrid
{
    private string $modelName = 'productBookSpineColor';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductBookSpineColorFieldEnum::PRODUCT_TITLE, readonly: true),
                $fieldCreator->text(ProductBookSpineColorFieldEnum::TITLE),
                $fieldCreator->color(ProductBookSpineColorFieldEnum::COLOR),
                $fieldCreator->checkbox(ProductBookSpineColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductBookSpineColorFieldEnum::SORT),
                $fieldCreator->select(ProductBookSpineColorFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
                $fieldCreator->upload(ProductBookSpineColorFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image'),

            ]),
        ];
    }
}
