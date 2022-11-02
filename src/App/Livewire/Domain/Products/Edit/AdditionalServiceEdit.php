<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\AdditionalServiceDeleteAction;
use Domain\Products\Actions\AdditionalServiceUpdateAction;
use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\FieldEnums\AdditionalServiceFieldEnum;
use Domain\Products\FormGrids\AdditionalServiceFormGrid;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Rules\AdditionalServiceRules;
use Livewire\Redirector;

class AdditionalServiceEdit extends Form
{
    public string $name = 'additional_service';

    public AdditionalService $additionalService;

    public function mount(AdditionalService $model): void
    {
        $this->additionalService = $model;
    }

    public function grids(): array
    {
        return app(AdditionalServiceFormGrid::class)();
    }

    public function rules(): array
    {
        return AdditionalServiceRules::getRules($this->additionalService);
    }

    public function update(AdditionalServiceUpdateAction $additionalServiceUpdateAction): Redirector|bool
    {
        $this->validate();
        $additionalServiceData = AdditionalServiceData::fromModel($this->additionalService);
        $this->additionalService = $additionalServiceUpdateAction($this->additionalService, $additionalServiceData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('additional_service.list'));
    }

    public function delete(AdditionalServiceDeleteAction $additionalServiceDeleteAction): Redirector
    {
        $additionalServiceDeleteAction($this->additionalService);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('additionalService.list'));
    }

    protected function validationAttributes(): array
    {
        return AdditionalServiceFieldEnum::labels();
    }
}
