<?php

namespace App\Livewire\Traits;

trait WithSearch
{
    public string $search = '';

    public string $searchPlaceholder = '';

    public function applySearching($query)
    {
        return $query->search($this->search);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
}
