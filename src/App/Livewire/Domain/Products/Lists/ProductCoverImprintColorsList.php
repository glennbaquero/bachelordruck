<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductCoverImprintColorDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverImprintColor;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverImprintColorsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productCoverImprintColors')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.productCoverImprintColor')]);
        $this->createRoute = route('product_cover_imprint_color.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->showModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_cover_imprint_colors/%s', $id))
            ),
            Column::text(field: 'title', token: 'productCoverImprintColor')->sortable(),
            Column::text(field: 'color', token: 'productCoverImprintColor')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productCoverImprintColor')->sortable(),
            Column::text(field: 'sort', token: 'productCoverImprintColor')->sortable(),
            Column::enum(field: 'status', token: 'productCoverImprintColor', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->editModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_cover_imprint_colors/%s/edit', $id))
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
        return ProductCoverImprintColor::query()
            ->when(isset($this->parentModelId) && $this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(ProductCoverImprintColorDeleteAction $productCoverImprintColorDeleteAction, ProductCoverImprintColor $productCoverImprintColor): void
    {
        if ($productCoverImprintColor->id === null) {
            $productCoverImprintColor = ProductCoverImprintColor::findOrFail($this->currentId);
        }

        $productCoverImprintColorDeleteAction($productCoverImprintColor);
        $this->showModalConfirmation = false;
    }
}
