<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductFormGrid
{
    private string $modelName = 'product';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductFieldEnum::SLUG),
                $fieldCreator->text(ProductFieldEnum::TITLE),
                $fieldCreator->text(ProductFieldEnum::TOOLTIP),
                $fieldCreator->text(ProductFieldEnum::DESCRIPTION),
                $fieldCreator->decimal(ProductFieldEnum::PRICE),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_COVER_COLOR),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_COVER_IMPRINT_COLOR),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_COVER_FOIL),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_BACK_COVER),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_BOOK_SPINE_LABEL),
                $fieldCreator->decimal(ProductFieldEnum::BOOK_SPINE_LABEL_SURCHARGE),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_BOOK_CORNERS),
                $fieldCreator->decimal(ProductFieldEnum::BOOK_CORNERS_SURCHARGE),
                $fieldCreator->checkbox(ProductFieldEnum::HAS_RIBBON),
                $fieldCreator->decimal(ProductFieldEnum::RIBBON_SURCHARGE),
                $fieldCreator->decimal(ProductFieldEnum::SORT),
                $fieldCreator->select(ProductFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
                $fieldCreator->upload(ProductFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image'),
            ]),
        ];
    }
}
