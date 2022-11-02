<?php

namespace App\Livewire\Domain\Employees\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Traits\WithAvatar;
use Domain\Employees\Actions\EmployeeDeleteAction;
use Domain\Employees\Actions\EmployeeUpdateAction;
use Domain\Employees\DataTransferObjects\EmployeeData;
use Domain\Employees\FieldEnums\EmployeeFieldEnum;
use Domain\Employees\FormGrids\EmployeeFormGrid;
use Domain\Employees\Models\Employee;
use Domain\Employees\Rules\EmployeeRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class EmployeeEdit extends Form
{
    use WithMedia;
    use WithAvatar;

    public string $name = 'employee';

    public Employee $employee;

    public function mount(Employee $model): void
    {
        $this->employee = $model;
        $this->employee->load(['divisions']);

        $this->avatarModel = $this->employee;
    }

    public function grids(): array
    {
        return app(EmployeeFormGrid::class)();
    }

    public function rules(): array
    {
        return EmployeeRules::getRules($this->employee);
    }

    public function update(EmployeeUpdateAction $employeeUpdateAction): Redirector
    {
        $this->validate();
        $employeeData = EmployeeData::fromModel($this->employee, $this->employee->division_ids);
        $this->employee = $employeeUpdateAction($this->employee, $employeeData);

        if ($this->avatar) {
            $this->employee->syncFromMediaLibraryRequest($this->avatar)->toMediaCollection('avatars');
        }

        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('employee.list'));
    }

    public function delete(EmployeeDeleteAction $employeeDeleteAction): Redirector
    {
        $employeeDeleteAction($this->employee);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('employee.list'));
    }

    protected function validationAttributes(): array
    {
        return EmployeeFieldEnum::labels();
    }
}
