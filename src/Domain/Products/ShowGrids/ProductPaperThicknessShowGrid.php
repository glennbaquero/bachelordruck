<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductPaperThicknessFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductPaperThicknessShowGrid
{
    private string $modelName = 'productPaperThickness';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: ProductPaperThicknessFieldEnum::TITLE),
                $fieldCreator->text(field: ProductPaperThicknessFieldEnum::TOOLTIP),
                $fieldCreator->text(field: ProductPaperThicknessFieldEnum::MAX_PAGES),
                $fieldCreator->decimal(field: ProductPaperThicknessFieldEnum::PRICE_PER_PAGE_BW),
                $fieldCreator->decimal(field: ProductPaperThicknessFieldEnum::PRICE_PER_PAGE_COLOR),
                $fieldCreator->checkbox(field: ProductPaperThicknessFieldEnum::IS_PRESELECTED),
                $fieldCreator->text(field: ProductPaperThicknessFieldEnum::SORT),
                $fieldCreator->enum(field: ProductPaperThicknessFieldEnum::STATUS, enum: StatusEnum::class),
            ], showTitle: false),
        ];
    }
}
