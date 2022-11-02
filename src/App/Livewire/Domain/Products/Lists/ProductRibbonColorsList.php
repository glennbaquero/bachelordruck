<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductRibbonColorDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductRibbonColor;
use Illuminate\Database\Eloquent\Builder;

class ProductRibbonColorsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productRibbonColors')]);
        $this->createButtonTitle = __('button.create_label');
        $this->createRoute = route('product_ribbon_color.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_ribbon_colors/%s', $id))
            ),
            Column::text(field: 'title', token: 'productRibbonColor')->sortable(),
            Column::color(field: 'color', token: 'productRibbonColor')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productRibbonColor')->sortable(),
            Column::text(field: 'sort', token: 'productRibbonColor')->sortable(),
            Column::enum(field: 'status', token: 'productRibbonColor', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_ribbon_colors/%s/edit', $id))
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
        return ProductRibbonColor::query();
    }

    public function delete(ProductRibbonColorDeleteAction $productRibbonColorDeleteAction, ProductRibbonColor $productRibbonColor): void
    {
        if ($productRibbonColor->id === null) {
            $productRibbonColor = ProductRibbonColor::findOrFail($this->currentId);
        }

        $productRibbonColorDeleteAction($productRibbonColor);
        $this->showModalConfirmation = false;
    }
}
