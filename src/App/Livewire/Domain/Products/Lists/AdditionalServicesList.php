<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\AdditionalServiceDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\AdditionalService;
use Illuminate\Database\Eloquent\Builder;

class AdditionalServicesList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.additionalServices')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.additionalService')]);
        $this->createRoute = route('additional_service.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->showModalCallback($id) :
                fn ($id) => redirect(sprintf('/additional_services/%s', $id))
            ),
            Column::text(field: 'title', token: 'additionalService')->sortable(),
            Column::text(field: 'tooltip', token: 'additionalService')->sortable(),
            Column::text(field: 'surcharge', token: 'additionalService')->sortable(),
            Column::text(field: 'sort', token: 'additionalService')->sortable(),
            Column::enum(field: 'status', token: 'additionalService', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->editModalCallback($id) :
                fn ($id) => redirect(sprintf('/additional_services/%s/edit', $id))
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
        return AdditionalService::query()
            ->when(isset($this->parentModelId) && $this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(AdditionalServiceDeleteAction $additionalServiceDeleteAction, AdditionalService $additionalService): void
    {
        if ($additionalService->id === null) {
            $additionalService = AdditionalService::findOrFail($this->currentId);
        }

        $additionalServiceDeleteAction($additionalService);
        $this->showModalConfirmation = false;
    }
}
