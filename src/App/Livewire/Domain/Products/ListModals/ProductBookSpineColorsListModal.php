<?php

namespace App\Livewire\Domain\Products\ListModals;

use App\Livewire\Domain\Products\Create\ProductBookSpineColorCreate;
use App\Livewire\Domain\Products\Edit\ProductBookSpineColorEdit;
use App\Livewire\Domain\Products\Show\ProductBookSpineColorShow;
use Closure;

trait ProductBookSpineColorsListModal
{
    public function mountProductBookSpineColorsListModal(): void
    {
        $this->pageName = 'productBookSpineColorPage';
        $this->searchName = 'searchProductBookSpineColors';
        $this->sortFieldName = 'sortFieldProductBookSpineColors';
        $this->parentModelLocalKey = 'product_id';
        $this->useModal = true;
    }

    public function createModalCallback(): Closure
    {
        return function () {
            $this->emitUp('showModal', ProductBookSpineColorCreate::getName(), $this->formTitle);
        };
    }

    public function editModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductBookSpineColorEdit::getName(),
            __('button.edit_model', ['model' => __('model.productBookSpineColor')]),
            (string) $modelId,
        );
    }

    public function showModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductBookSpineColorShow::getName(),
            __('button.show_model', ['model' => __('model.productBookSpineColor')]),
            (string) $modelId,
        );
    }
}
