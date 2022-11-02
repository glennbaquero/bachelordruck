<?php

namespace App\Livewire\Domain\Products\ListModals;

use App\Livewire\Domain\Products\Create\ProductPaperThicknessCreate;
use App\Livewire\Domain\Products\Edit\ProductPaperThicknessEdit;
use App\Livewire\Domain\Products\Show\ProductPaperThicknessShow;
use Closure;

trait ProductPaperThicknessesListModal
{
    public function mountProductPaperThicknessesListModal(): void
    {
        $this->pageName = 'productPaperThicknessesPage';
        $this->searchName = 'searchProductPaperThicknesses';
        $this->sortFieldName = 'sortFieldProductPaperThicknesses';
        $this->parentModelLocalKey = 'product_id';
        $this->useModal = true;
    }

    public function createModalCallback(): Closure
    {
        return function () {
            $this->emitUp('showModal', ProductPaperThicknessCreate::getName(), $this->formTitle);
        };
    }

    public function editModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductPaperThicknessEdit::getName(),
            __('button.edit_model', ['model' => __('model.productPaperThickness')]),
            (string) $modelId,
        );
    }

    public function showModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductPaperThicknessShow::getName(),
            __('button.show_model', ['model' => __('model.productPaperThickness')]),
            (string) $modelId,
        );
    }
}
