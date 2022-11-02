<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\ProductBookCornerColorDeleteAction;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\ShowGrids\ProductBookCornerColorShowGrid;
use Livewire\Redirector;

class ProductBookCornerColorShow extends Show
{
    public string $name = 'product_book_corner_color';

    public ProductBookCornerColor   $model;

    public function mount(ProductBookCornerColor $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(ProductBookCornerColorShowGrid::class)();
    }

    public function delete(ProductBookCornerColorDeleteAction $productBookCornerColorDeleteAction): Redirector
    {
        $productBookCornerColorDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_book_corner_color.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_book_corner_color.edit', ['model' => $this->model->id]));
    }
}
