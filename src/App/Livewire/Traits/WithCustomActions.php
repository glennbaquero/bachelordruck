<?php

namespace App\Livewire\Traits;

use function app;

trait WithCustomActions
{
    public function customAction(string|int $id, string $label)
    {
        $column = $this->getColumn('custom');

        $actionItem = collect($column->getCustomActions())
            ->where('label', $label)
            ->first();

        return app()->call($actionItem['action'], ['id' => $id]);
    }
}
