<?php

namespace App\Livewire\Domain\Divisions\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Divisions\Actions\DivisionDeleteAction;
use Domain\Divisions\Enums\DivisionTypeEnum;
use Domain\Divisions\Models\Division;
use Illuminate\Database\Eloquent\Builder;

class DivisionsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.divisions')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.division')]);
        $this->createRoute = route('division.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/divisions/%s', $id))
            ),
            Column::text(field: 'name', token: 'division')->sortable(),
            Column::enum(field: 'type', token: 'division', enum: DivisionTypeEnum::class)->sortable(),
            Column::text(field: 'sort', token: 'division')->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/divisions/%s/edit', $id))
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
        return Division::query();
    }

    public function delete(DivisionDeleteAction $divisionDeleteAction, Division $division): void
    {
        if ($division->id === null) {
            $division = Division::findOrFail($this->currentId);
        }

        $divisionDeleteAction($division);
        $this->showModalConfirmation = false;
    }
}
