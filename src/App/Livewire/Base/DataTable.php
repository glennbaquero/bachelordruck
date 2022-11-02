<?php

namespace App\Livewire\Base;

use App\Livewire\Traits\WithCreateAction;
use App\Livewire\Traits\WithCustomActions;
use App\Livewire\Traits\WithCustomPagination;
use App\Livewire\Traits\WithDeleteAction;
use App\Livewire\Traits\WithEditAction;
use App\Livewire\Traits\WithModals;
use App\Livewire\Traits\WithParentModel;
use App\Livewire\Traits\WithSearch;
use App\Livewire\Traits\WithShowAction;
use App\Livewire\Traits\WithSorting;
use App\Livewire\View\Column;
use function collect;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use function view;

abstract class DataTable extends Component
{
    use WithCustomPagination;
    use WithSorting;
    use WithSearch;
    use WithShowAction;
    use WithEditAction;
    use WithModals;
    use WithDeleteAction;
    use WithCreateAction;
    use WithCustomActions;
    use WithParentModel;

    protected $listeners = ['formSaved' => '$refresh'];

    /**
     * The array defining the columns of the table.
     *
     * @return array
     */
    abstract public function columns(): array;

    /**
     * The base query with search and filters for the table.
     */
    abstract public function query(): Builder;

    public function rowsQuery(): Builder
    {
        $query = $this->query();

        if (method_exists($this, 'applySorting')) {
            $query = $this->applySorting($query);
        }

        if (method_exists($this, 'applySearching')) {
            $query = $this->applySearching($query);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getRowsProperty()
    {
        if ($this->paginationEnabled) {
            return $this->applyPagination($this->rowsQuery());
        }

        return $this->rowsQuery()->get();
    }

    public function getColumn(string $field): Column
    {
        return collect($this->columns())
            ->where('field', $field)
            ->first();
    }

    public function render()
    {
        return view('livewire.datatable')
            ->with([
                'columns' => $this->columns(),
                'rows' => $this->rows,
            ]);
    }

    protected function queryString()
    {
        return [
            'search' => ['except' => '', 'as' => ($this->searchName ?? 'search')],
            'sortField' => ['except' => 'id', 'as' => ($this->sortFieldName ?? 'sortField')],
            'sortAsc' => ['except' => true, 'as' => ($this->sortAscName ?? 'sortAsc')],
        ];
    }
}
