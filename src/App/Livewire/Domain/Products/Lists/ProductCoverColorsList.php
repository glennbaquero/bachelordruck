<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\Domain\Products\ListModals\ProductCoverColorsListModal;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductCoverColorDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverColor;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverColorsList extends DataTable
{
    use ProductCoverColorsListModal;

    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productCoverColors')]);
        $this->createButtonTitle = __('button.create_label');
        $this->formTitle = __('button.create', ['model' => __('model.productCoverColor')]);
        $this->createRoute = route('product_cover_color.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->showModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_cover_colors/%s', $id))
            ),
            Column::text(field: 'title', token: 'productCoverColor')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productCoverColor')->sortable(),
            Column::text(field: 'sort', token: 'productCoverColor')->sortable(),
            Column::enum(field: 'status', token: 'productCoverColor', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                $this->useModal ?
                fn ($id) => $this->editModalCallback($id) :
                fn ($id) => redirect(sprintf('/product_cover_colors/%s/edit', $id))
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
        return ProductCoverColor::query()
            ->when($this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(ProductCoverColorDeleteAction $productCoverColorDeleteAction, ProductCoverColor $productCoverColor): void
    {
        if ($productCoverColor->id === null) {
            $productCoverColor = ProductCoverColor::findOrFail($this->currentId);
        }

        $productCoverColorDeleteAction($productCoverColor);
        $this->showModalConfirmation = false;
    }
}
