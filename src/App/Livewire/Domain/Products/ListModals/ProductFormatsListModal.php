<?php

namespace App\Livewire\Domain\Products\ListModals;

use App\Livewire\Domain\Products\Create\ProductFormatCreate;
use App\Livewire\Domain\Products\Edit\ProductFormatEdit;
use App\Livewire\Domain\Products\Show\ProductFormatShow;
use Closure;

trait ProductFormatsListModal
{
    public function mountProductFormatsListModal(): void
    {
        $this->pageName = 'productFormatPage';
        $this->searchName = 'searchProductFormats';
        $this->sortFieldName = 'sortFieldProductFormats';
        $this->parentModelLocalKey = 'product_id';
        $this->useModal = true;
    }

    public function createModalCallback(): Closure
    {
        return function () {
            $this->emitUp('showModal', ProductFormatCreate::getName(), $this->formTitle);
        };
    }

    public function editModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductFormatEdit::getName(),
            __('button.edit_model', ['model' => __('model.productFormat')]),
            (string) $modelId,
        );
    }

    public function showModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductFormatShow::getName(),
            __('button.show_model', ['model' => __('model.productFormat')]),
            (string) $modelId,
        );
    }
}
