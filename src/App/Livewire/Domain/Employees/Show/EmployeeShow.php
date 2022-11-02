<?php

namespace App\Livewire\Domain\Employees\Show;

use App\Livewire\Base\Show;
use Domain\Employees\Actions\EmployeeDeleteAction;
use Domain\Employees\Models\Employee;
use Domain\Employees\ShowGrids\EmployeeShowGrid;
use Livewire\Redirector;

class EmployeeShow extends Show
{
    public string $name = 'employee';

    public Employee   $model;

    public function mount(Employee $model): void
    {
        $this->model = $model;

        $this->model->load(['divisions']);
    }

    public function grids(): array
    {
        return app(EmployeeShowGrid::class)();
    }

    public function delete(EmployeeDeleteAction $employeeDeleteAction): Redirector
    {
        $employeeDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('employee.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('employee.edit', ['model' => $this->model->id]));
    }
}
