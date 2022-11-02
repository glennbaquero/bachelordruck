<?php

namespace App\Livewire\Traits;

trait WithDeleteAction
{
    public bool $showModalConfirmation = false;

    public bool $enableDeleteConfirmation = true;

    public function deleteAction($id = null)
    {
        if ($id !== null) {
            $this->currentId = $id;
        }
        $column = $this->getColumn('delete');

        return app()->call($column->getCallback(), ['id' => $this->currentId]);
    }
}
