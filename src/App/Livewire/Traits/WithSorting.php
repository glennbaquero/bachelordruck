<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithSorting
{
    public string $sortField = 'id';

    public bool $sortAsc = true;

    public string $sortFieldName = 'sortField';

    public string $sortAscName = 'sortAsc';

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    /**
     * @param $query
     * @return Builder
     */
    public function applySorting($query): Builder
    {
        return $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }
}
