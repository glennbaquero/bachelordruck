<?php

namespace Domain\Products\ShowGrids;

use App\Livewire\Domain\Products\Lists\ProductBookSpineColorsList;
use App\Livewire\Domain\Products\Lists\ProductCoverColorsList;
use App\Livewire\Domain\Products\Lists\ProductFormatsList;
use App\Livewire\Domain\Products\Lists\ProductPaperThicknessesList;
use App\Livewire\View\Fieldset;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\FieldEnums\ProductFieldEnum;
use Support\Creators\OutputFieldCreator;

class ProductShowGrid
{
    private string $modelName = 'product';

    public function __invoke(): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        return [
            Fieldset::make(fields: [
                $fieldCreator->text(field: ProductFieldEnum::SLUG),
                $fieldCreator->text(field: ProductFieldEnum::TITLE),
                $fieldCreator->text(field: ProductFieldEnum::TOOLTIP),
                $fieldCreator->text(field: ProductFieldEnum::DESCRIPTION),
                $fieldCreator->decimal(field: ProductFieldEnum::PRICE),
                $fieldCreator->decimal(field: ProductFieldEnum::BOOK_SPINE_LABEL_SURCHARGE),
                $fieldCreator->decimal(field: ProductFieldEnum::BOOK_CORNERS_SURCHARGE),
                $fieldCreator->decimal(field: ProductFieldEnum::RIBBON_SURCHARGE),
                $fieldCreator->text(field: ProductFieldEnum::SORT),
                $fieldCreator->enum(field: ProductFieldEnum::STATUS, enum: StatusEnum::class),

                $fieldCreator->childList(module: ProductPaperThicknessesList::class, title: __('model.productPaperThicknesses')),
                $fieldCreator->childList(module: ProductCoverColorsList::class, title: __('model.productCoverColors')),
                $fieldCreator->childList(module: ProductBookSpineColorsList::class, title: __('model.productBookSpineColors')),
                $fieldCreator->childList(module: ProductFormatsList::class, title: __('model.productFormats')),
            ]),
            Fieldset::make(fields: [
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_COVER_COLOR),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_COVER_IMPRINT_COLOR),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_COVER_FOIL),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_BACK_COVER),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_BOOK_SPINE_LABEL),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_BOOK_CORNERS),
                $fieldCreator->checkbox(field: ProductFieldEnum::HAS_RIBBON),
            ]),
        ];
    }
}
