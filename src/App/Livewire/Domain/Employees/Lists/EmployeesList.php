<?php

namespace App\Livewire\Domain\Employees\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Divisions\Models\Division;
use Domain\Employees\Actions\EmployeeDeleteAction;
use Domain\Employees\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class EmployeesList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.employees')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.employee')]);
        $this->createRoute = route('employee.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/employees/%s', $id))
            ),
            Column::text(field: 'position', token: 'employee')->sortable(),
            Column::select(field: 'division_ids', token: 'employee', options: Division::selectOptions()),
            Column::text(field: 'name', token: 'employee')->sortable(),
            Column::text(field: 'email', token: 'employee')->sortable(),
            Column::text(field: 'tel', token: 'employee')->sortable(),
            Column::text(field: 'fax', token: 'employee')->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/employees/%s/edit', $id))
            ),
            Column::action(
                action: 'delete'
            )->setCallback(
                function ($id) {
                    $this->currentId = $id;
                    $this->showModalConfirmation = true;
                }
            ),
        ];
    }

    public function query(): Builder
    {
        return Employee::with(['divisions']);
    }

    public function delete(EmployeeDeleteAction $employeeDeleteAction, Employee $employee): void
    {
        if ($employee->id === null) {
            $employee = Employee::findOrFail($this->currentId);
        }

        $employeeDeleteAction($employee);
        $this->showModalConfirmation = false;
    }
}
