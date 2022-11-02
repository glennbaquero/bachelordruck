<?php

namespace Domain\Products\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductPaperThicknessFieldEnum;
use Support\Creators\FormFieldCreator;

class ProductPaperThicknessFormGrid
{
    private string $modelName = 'productPaperThickness';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(ProductPaperThicknessFieldEnum::PRODUCT_TITLE, readonly: true),
                $fieldCreator->text(ProductPaperThicknessFieldEnum::TITLE),
                $fieldCreator->text(ProductPaperThicknessFieldEnum::TOOLTIP),
                $fieldCreator->decimal(ProductPaperThicknessFieldEnum::MAX_PAGES),
                $fieldCreator->decimal(ProductPaperThicknessFieldEnum::PRICE_PER_PAGE_BW),
                $fieldCreator->decimal(ProductPaperThicknessFieldEnum::PRICE_PER_PAGE_COLOR),
                $fieldCreator->checkbox(ProductPaperThicknessFieldEnum::IS_PRESELECTED),
                $fieldCreator->decimal(ProductPaperThicknessFieldEnum::SORT),
                $fieldCreator->select(ProductPaperThicknessFieldEnum::STATUS)
                    ->options(StatusEnum::options()),
            ], showTitle: false),
        ];
    }
}
