<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\Domain\Products\ListModals\ProductPaperThicknessesListModal;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductPaperThicknessDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductPaperThickness;
use Illuminate\Database\Eloquent\Builder;

class ProductPaperThicknessesList extends DataTable
{
    use ProductPaperThicknessesListModal;

    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productPaperThicknesses')]);
        $this->createButtonTitle = __('button.create_label');
        $this->formTitle = __('button.create', ['model' => __('model.productPaperThickness')]);
        $this->createRoute = route('product_paper_thickness.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->showModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_paper_thicknesses/%s', $id))
            ),
            Column::text(field: 'title', token: 'productPaperThickness')->sortable(),
            Column::text(field: 'tooltip', token: 'productPaperThickness')->sortable(),
            Column::text(field: 'max_pages', token: 'productPaperThickness')->sortable(),
            Column::text(field: 'price_per_page_bw', token: 'productPaperThickness')->sortable(),
            Column::text(field: 'price_per_page_color', token: 'productPaperThickness')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productPaperThickness')->sortable(),
            Column::text(field: 'sort', token: 'productPaperThickness')->sortable(),
            Column::enum(field: 'status', token: 'productPaperThickness', enum: StatusEnum::class)->sortable(),
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
        return ProductPaperThickness::query()
            ->when($this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(ProductPaperThicknessDeleteAction $productPaperThicknessDeleteAction, ProductPaperThickness $productPaperThickness): void
    {
        if ($productPaperThickness->id === null) {
            $productPaperThickness = ProductPaperThickness::findOrFail($this->currentId);
        }

        $productPaperThicknessDeleteAction($productPaperThickness);
        $this->showModalConfirmation = false;
    }
}
