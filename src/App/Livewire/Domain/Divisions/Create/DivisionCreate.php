<?php

namespace App\Livewire\Domain\Divisions\Create;

use App\Livewire\Base\Form;
use Domain\Divisions\Actions\DivisionCreateAction;
use Domain\Divisions\DataTransferObjects\DivisionData;
use Domain\Divisions\FieldEnums\DivisionFieldEnum;
use Domain\Divisions\FormGrids\DivisionFormGrid;
use Domain\Divisions\Models\Division;
use Domain\Divisions\Presets\DivisionPreset;
use Domain\Divisions\Rules\DivisionRules;
use Livewire\Redirector;

class DivisionCreate extends Form
{
    public string $name = 'division';

    public Division $division;

    public string $method = 'create';

    public function mount(): void
    {
        $this->division = app(DivisionPreset::class)();
    }

    public function grids(): array
    {
        return app(DivisionFormGrid::class)();
    }

    public function rules(): array
    {
        return DivisionRules::getRules($this->division);
    }

    public function create(DivisionCreateAction $divisionCreateAction): Redirector
    {
        $this->validate();
        $divisionData = DivisionData::fromModel($this->division);
        $this->division = $divisionCreateAction($divisionData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('division.list'));
    }

    protected function validationAttributes(): array
    {
        return DivisionFieldEnum::labels();
    }
}
