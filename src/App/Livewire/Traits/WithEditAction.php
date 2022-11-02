<?php

namespace App\Livewire\Traits;

use function app;

trait WithEditAction
{
    public function editAction($id)
    {
        $column = $this->getColumn('edit');

        return app()->call($column->getCallback(), ['id' => $id]);
    }
}
