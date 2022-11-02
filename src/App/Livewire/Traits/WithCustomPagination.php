<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait WithCustomPagination
{
    use WithPagination;

    public int $perPage = 10;

    public bool $paginationEnabled = true;

    public string $pageName = 'page';

    public function applyPagination($query)
    {
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }
}
