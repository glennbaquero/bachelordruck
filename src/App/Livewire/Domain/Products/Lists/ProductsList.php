<?php

namespace App\Livewire\Domain\Products\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Products\Actions\ProductDeleteAction;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.products')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.product')]);
        $this->createRoute = route('product.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/products/%s', $id))
            ),
            Column::text(field: 'title', token: 'product')->sortable(),
            Column::text(field: 'tooltip', token: 'product')->sortable(),
            Column::text(field: 'description', token: 'product')->sortable(),
            Column::text(field: 'price', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_cover_color', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_cover_imprint_color', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_cover_foil', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_back_cover', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_book_spine_label', token: 'product')->sortable(),
            //            Column::text(field: 'book_spine_label_surcharge', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_book_corners', token: 'product')->sortable(),
            //            Column::text(field: 'book_corners_surcharge', token: 'product')->sortable(),
            //            Column::boolean(field: 'has_ribbon', token: 'product')->sortable(),
            //            Column::text(field: 'ribbon_surcharge', token: 'product')->sortable(),
            //            Column::text(field: 'sort', token: 'product')->sortable(),
            Column::enum(field: 'status', token: 'product', enum: StatusEnum::class)->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/products/%s/edit', $id))
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
        return Product::query();
    }

    public function delete(ProductDeleteAction $productDeleteAction, Product $product): void
    {
        if ($product->id === null) {
            $product = Product::findOrFail($this->currentId);
        }

        $productDeleteAction($product);
        $this->showModalConfirmation = false;
    }
}
