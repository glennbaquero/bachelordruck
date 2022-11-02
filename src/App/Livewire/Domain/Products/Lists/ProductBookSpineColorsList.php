<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\Domain\Products\ListModals\ProductBookSpineColorsListModal;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductBookSpineColorDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookSpineColor;
use Illuminate\Database\Eloquent\Builder;

class ProductBookSpineColorsList extends DataTable
{
    use ProductBookSpineColorsListModal;

    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productBookSpineColors')]);
        $this->createButtonTitle = __('button.create_label');
        $this->formTitle = __('button.create', ['model' => __('model.productBookSpineColor')]);
        $this->createRoute = route('product_book_spine_color.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->showModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_book_spine_colors/%s', $id))
            ),
            Column::text(field: 'title', token: 'productBookSpineColor')->sortable(),
            Column::color(field: 'color', token: 'productBookSpineColor')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productBookSpineColor')->sortable(),
            Column::text(field: 'sort', token: 'productBookSpineColor')->sortable(),
            Column::enum(field: 'status', token: 'productBookSpineColor', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->editModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_paper_thicknesses/%s/edit', $id))
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
        return ProductBookSpineColor::query()
            ->when($this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(ProductBookSpineColorDeleteAction $productBookSpineColorDeleteAction, ProductBookSpineColor $productBookSpineColor): void
    {
        if ($productBookSpineColor->id === null) {
            $productBookSpineColor = ProductBookSpineColor::findOrFail($this->currentId);
        }

        $productBookSpineColorDeleteAction($productBookSpineColor);
        $this->showModalConfirmation = false;
    }
}
