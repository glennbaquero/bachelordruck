<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\Domain\Products\ListModals\ProductFormatsListModal;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductFormatDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductFormat;
use Illuminate\Database\Eloquent\Builder;

class ProductFormatsList extends DataTable
{
    use ProductFormatsListModal;

    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.productFormats')]);
        $this->createButtonTitle = __('button.create_label');
        $this->formTitle = __('button.create', ['model' => __('model.productFormat')]);
        $this->createRoute = route('product_format.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                $this->useModal ?
                    fn ($id) => $this->showModalCallback($id) :
                    fn ($id) => redirect(sprintf('/product_formats/%s', $id))
            ),
            Column::text(field: 'title', token: 'productFormat')->sortable(),
            Column::boolean(field: 'is_preselected', token: 'productFormat')->sortable(),
            Column::text(field: 'sort', token: 'productFormat')->sortable(),
            Column::enum(field: 'status', token: 'productFormat', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                $this->useModal ?
                    fn ($id) => $this->editModalCallback($id) :
                    fn ($id) => redirect(sprintf('/product_formats/%s/edit', $id))
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
        return ProductFormat::query()
            ->when($this->parentModelId && $this->parentModelLocalKey, function (Builder $builder) {
                $builder->where($this->parentModelLocalKey, $this->parentModelId);
            });
    }

    public function delete(ProductFormatDeleteAction $productFormatDeleteAction, ProductFormat $productFormat): void
    {
        if ($productFormat->id === null) {
            $productFormat = ProductFormat::findOrFail($this->currentId);
        }

        $productFormatDeleteAction($productFormat);
        $this->showModalConfirmation = false;
    }
}
