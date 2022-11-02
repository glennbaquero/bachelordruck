<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductCoverFoilDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverFoil;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverFoilsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productCoverFoils')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.productCoverFoil')]);
        $this->createRoute = route('product_cover_foil.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_cover_foils/%s', $id))
            ),
            Column::text(field: 'title', token: 'productCoverFoil')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productCoverFoil')->sortable(),
            Column::text(field: 'sort', token: 'productCoverFoil')->sortable(),
            Column::enum(field: 'status', token: 'productCoverFoil', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_cover_foils/%s/edit', $id))
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
        return ProductCoverFoil::query();
    }

    public function delete(ProductCoverFoilDeleteAction $productCoverFoilDeleteAction, ProductCoverFoil $productCoverFoil): void
    {
        if ($productCoverFoil->id === null) {
            $productCoverFoil = ProductCoverFoil::findOrFail($this->currentId);
        }

        $productCoverFoilDeleteAction($productCoverFoil);
        $this->showModalConfirmation = false;
    }
}
