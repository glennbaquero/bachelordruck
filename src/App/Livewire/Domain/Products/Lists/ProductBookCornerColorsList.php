<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductBookCornerColorDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookCornerColor;
use Illuminate\Database\Eloquent\Builder;

class ProductBookCornerColorsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productBookCornerColors')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.productBookCornerColor')]);
        $this->createRoute = route('product_book_corner_color.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_book_corner_colors/%s', $id))
            ),
            Column::text(field: 'title', token: 'productBookCornerColor')->sortable(),
            Column::color(field: 'color', token: 'productBookCornerColor')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productBookCornerColor')->sortable(),
            Column::text(field: 'sort', token: 'productBookCornerColor')->sortable(),
            Column::enum(field: 'status', token: 'productBookCornerColor', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_book_corner_colors/%s/edit', $id))
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
        return ProductBookCornerColor::query();
    }

    public function delete(ProductBookCornerColorDeleteAction $productBookCornerColorDeleteAction, ProductBookCornerColor $productBookCornerColor): void
    {
        if ($productBookCornerColor->id === null) {
            $productBookCornerColor = ProductBookCornerColor::findOrFail($this->currentId);
        }

        $productBookCornerColorDeleteAction($productBookCornerColor);
        $this->showModalConfirmation = false;
    }
}
