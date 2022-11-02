<?php

namespace App\Livewire\Domain\Employees\Create;

use App\Livewire\Base\Form;
use App\Livewire\Traits\WithAvatar;
use Domain\Employees\Actions\EmployeeCreateAction;
use Domain\Employees\DataTransferObjects\EmployeeData;
use Domain\Employees\FieldEnums\EmployeeFieldEnum;
use Domain\Employees\FormGrids\EmployeeFormGrid;
use Domain\Employees\Models\Employee;
use Domain\Employees\Presets\EmployeePreset;
use Domain\Employees\Rules\EmployeeRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class EmployeeCreate extends Form
{
    use WithMedia;
    use WithAvatar;

    public string $name = 'employee';

    public Employee $employee;

    public string $method = 'create';

    public function mount(): void
    {
        $this->employee = app(EmployeePreset::class)();

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

    public function create(EmployeeCreateAction $employeeCreateAction): Redirector
    {
        $this->validate();
        $employeeData = EmployeeData::fromModel($this->employee, $this->employee->division_ids);

        $this->employee = $employeeCreateAction($employeeData);
        $this->employee->addFromMediaLibraryRequest($this->avatar)->toMediaCollection('avatars');

        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('employee.list'));
    }

    protected function validationAttributes(): array
    {
        return EmployeeFieldEnum::labels();
    }
}
