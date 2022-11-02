<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductBookSpineColorDeleteAction;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\ShowGrids\ProductBookSpineColorShowGrid;
use Livewire\Redirector;

class ProductBookSpineColorShow extends Show
{
    use WithParentModel;

    public string $name = 'productBookSpineColor';

    public ProductBookSpineColor $productBookSpineColor;

    public function mount(ProductBookSpineColor $model): void
    {
        $this->productBookSpineColor = $model;
    }

    public function grids(): array
    {
        return app(ProductBookSpineColorShowGrid::class)();
    }

    public function delete(ProductBookSpineColorDeleteAction $productBookSpineColorDeleteAction): Redirector
    {
        $productBookSpineColorDeleteAction($this->productBookSpineColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_book_spine_color.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_book_spine_color.edit', ['model' => $this->productBookSpineColor->id]));
    }

    public function getModel()
    {
        return $this->productBookSpineColor;
    }
}
