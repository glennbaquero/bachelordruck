<?php

namespace App\Livewire\Domain\Products\ShowModals;

use App\Livewire\Traits\WithModals;

trait ProductShowModal
{
    use WithModals;

    public string $modalChildModel = 'productShowChildModel';

    public string $modalName = 'productShowModalName';

    public string $modalTitle = 'productShowModalTitle';

    protected function queryStringProductShowModal()
    {
        return [
            'modalComponentName' => ['except' => '', 'as' => $this->modalName],
            'modalComponentTitle' => ['except' => '', 'as' => $this->modalTitle],
            'childModelId' => ['except' => '', 'as' => $this->modalChildModel],
        ];
    }
}
