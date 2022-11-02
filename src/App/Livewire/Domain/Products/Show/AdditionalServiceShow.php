<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\AdditionalServiceDeleteAction;
use Domain\Products\Models\AdditionalService;
use Domain\Products\ShowGrids\AdditionalServiceShowGrid;
use Livewire\Redirector;

class AdditionalServiceShow extends Show
{
    public string $name = 'additional_service';

    public AdditionalService $additionalService;

    public function mount(AdditionalService $model): void
    {
        $this->additionalService = $model;
    }

    public function grids(): array
    {
        return app(AdditionalServiceShowGrid::class)();
    }

    public function delete(AdditionalServiceDeleteAction $additionalServiceDeleteAction): Redirector
    {
        $additionalServiceDeleteAction($this->additionalService);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('additional_service.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('additionalService.edit', ['model' => $this->additionalService->id]));
    }

    public function getModel()
    {
        return $this->additionalService;
    }
}
