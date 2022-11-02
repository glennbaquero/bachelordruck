<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductBackCoverDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBackCover;
use Illuminate\Database\Eloquent\Builder;

class ProductBackCoversList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productBackCovers')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.productBackCover')]);
        $this->createRoute = route('product_back_cover.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_back_covers/%s', $id))
            ),
            Column::text(field: 'title', token: 'productBackCover')->sortable(),
            Column::color(field: 'color', token: 'productBackCover')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productBackCover')->sortable(),
            Column::text(field: 'sort', token: 'productBackCover')->sortable(),
            Column::enum(field: 'status', token: 'productBackCover', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/product_back_covers/%s/edit', $id))
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
        return ProductBackCover::query();
    }

    public function delete(ProductBackCoverDeleteAction $productBackCoverDeleteAction, ProductBackCover $productBackCover): void
    {
        if ($productBackCover->id === null) {
            $productBackCover = ProductBackCover::findOrFail($this->currentId);
        }

        $productBackCoverDeleteAction($productBackCover);
        $this->showModalConfirmation = false;
    }
}
