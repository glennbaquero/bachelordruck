<?php

namespace App\Livewire\Domain\Divisions\Edit;

use App\Livewire\Base\Form;
use Domain\Divisions\Actions\DivisionDeleteAction;
use Domain\Divisions\Actions\DivisionUpdateAction;
use Domain\Divisions\DataTransferObjects\DivisionData;
use Domain\Divisions\FieldEnums\DivisionFieldEnum;
use Domain\Divisions\FormGrids\DivisionFormGrid;
use Domain\Divisions\Models\Division;
use Domain\Divisions\Rules\DivisionRules;
use Livewire\Redirector;

class DivisionEdit extends Form
{
    public string $name = 'division';

    public Division $division;

    public function mount(Division $model): void
    {
        $this->division = $model;
    }

    public function grids(): array
    {
        return app(DivisionFormGrid::class)();
    }

    public function rules(): array
    {
        return DivisionRules::getRules($this->division);
    }

    public function update(DivisionUpdateAction $divisionUpdateAction): Redirector
    {
        $this->validate();
        $divisionData = DivisionData::fromModel($this->division);
        $this->division = $divisionUpdateAction($this->division, $divisionData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('division.list'));
    }

    public function delete(DivisionDeleteAction $divisionDeleteAction): Redirector
    {
        $divisionDeleteAction($this->division);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('division.list'));
    }

    protected function validationAttributes(): array
    {
        return DivisionFieldEnum::labels();
    }
}
