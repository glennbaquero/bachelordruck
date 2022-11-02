<?php

namespace App\Livewire\Traits;

trait WithFormDeleteAction
{
    public bool $enableDeleteConfirmation = true;

    public bool $hideDeleteButton = false;

    public bool $showModalConfirmation = false;

    public function deleteAction(): void
    {
        $this->showModalConfirmation = true;
    }
}
