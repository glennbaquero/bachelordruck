<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductCoverImprintColorFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductCoverImprintColorFormGrid
{
    private string $modelName = 'productCoverImprintColor';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductCoverImprintColorFieldEnum::TITLE),
                $fieldCreator->color(ProductCoverImprintColorFieldEnum::COLOR),
                $fieldCreator->checkbox(ProductCoverImprintColorFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(ProductCoverImprintColorFieldEnum::SORT),
                $fieldCreator->select(ProductCoverImprintColorFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ]),
        ];
    }
}
