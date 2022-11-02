<?php

namespace App\Livewire\Traits;

use function app;

trait WithShowAction
{
    public function showAction($id)
    {
        $column = $this->getColumn('show');

        return app()->call($column->getCallback(), ['id' => $id]);
    }
}
