<?php

namespace App\Livewire\Domain\Products\ListModals;

use App\Livewire\Domain\Products\Create\ProductCoverColorCreate;
use App\Livewire\Domain\Products\Edit\ProductCoverColorEdit;
use App\Livewire\Domain\Products\Show\ProductCoverColorShow;
use Closure;

trait ProductCoverColorsListModal
{
    public function mountProductCoverColorsListModal(): void
    {
        $this->pageName = 'productCoverColorPage';
        $this->searchName = 'searchProductCoverColors';
        $this->sortFieldName = 'sortFieldProductCoverColors';
        $this->parentModelLocalKey = 'product_id';
        $this->useModal = true;
    }

    public function createModalCallback(): Closure
    {
        return function () {
            $this->emitUp('showModal', ProductCoverColorCreate::getName(), $this->formTitle);
        };
    }

    public function editModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductCoverColorEdit::getName(),
            __('button.edit_model', ['model' => __('model.productCoverColor')]),
            (string) $modelId,
        );
    }

    public function showModalCallback(int|string $modelId)
    {
        $this->emitUp(
            'showModal',
            ProductCoverColorShow::getName(),
            __('button.show_model', ['model' => __('model.productCoverColor')]),
            (string) $modelId,
        );
    }
}
