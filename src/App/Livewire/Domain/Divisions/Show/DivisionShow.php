<?php

namespace App\Livewire\Domain\Divisions\Show;

use App\Livewire\Base\Show;
use Domain\Divisions\Actions\DivisionDeleteAction;
use Domain\Divisions\Models\Division;
use Domain\Divisions\ShowGrids\DivisionShowGrid;
use Livewire\Redirector;

class DivisionShow extends Show
{
    public string $name = 'division';

    public Division   $model;

    public function mount(Division $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(DivisionShowGrid::class)();
    }

    public function delete(DivisionDeleteAction $divisionDeleteAction): Redirector
    {
        $divisionDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('division.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('division.edit', ['model' => $this->model->id]));
    }
}
