<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverColorFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductCoverColorFormGrid
{
    private string $modelName = 'productCoverColor';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductCoverColorFieldEnum::PRODUCT_TITLE, readonly: true),
                $fieldCreator->text(ProductCoverColorFieldEnum::TITLE),
                $fieldCreator->checkbox(ProductCoverColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductCoverColorFieldEnum::SORT),
                $fieldCreator->select(ProductCoverColorFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
                $fieldCreator->upload(ProductCoverColorFieldEnum::IMAGE, label: 'Image', rules: 'mimes:jpeg,jpg,png|max:65536', mediaCollectionName: 'image'),
            ]),
        ];
    }
}
