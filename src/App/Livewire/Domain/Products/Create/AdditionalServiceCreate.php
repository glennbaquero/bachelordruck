<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\AdditionalServiceCreateAction;
use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\FieldEnums\AdditionalServiceFieldEnum;
use Domain\Products\FormGrids\AdditionalServiceFormGrid;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Presets\AdditionalServicePreset;
use Domain\Products\Rules\AdditionalServiceRules;
use Livewire\Redirector;

class AdditionalServiceCreate extends Form
{
    public string $name = 'additional_service';

    public AdditionalService $additionalService;

    public string $method = 'create';

    public function mount(): void
    {
        $this->additionalService = app(AdditionalServicePreset::class)();
    }

    public function grids(): array
    {
        return app(AdditionalServiceFormGrid::class)();
    }

    public function rules(): array
    {
        return AdditionalServiceRules::getRules($this->additionalService);
    }

    public function create(AdditionalServiceCreateAction $additionalServiceCreateAction): Redirector|bool
    {
        $this->validate();
        $additionalServiceData = AdditionalServiceData::fromModel($this->additionalService);
        $this->additionalService = $additionalServiceCreateAction($additionalServiceData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('additional_service.list'));
    }

    protected function validationAttributes(): array
    {
        return AdditionalServiceFieldEnum::labels();
    }
}
