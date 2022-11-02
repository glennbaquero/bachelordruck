<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\ProductRibbonColorDeleteAction;
use Domain\Products\Models\ProductRibbonColor;
use Domain\Products\ShowGrids\ProductRibbonColorShowGrid;
use Livewire\Redirector;

class ProductRibbonColorShow extends Show
{
    public string $name = 'product_ribbon_color';

    public ProductRibbonColor   $model;

    public function mount(ProductRibbonColor $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(ProductRibbonColorShowGrid::class)();
    }

    public function delete(ProductRibbonColorDeleteAction $productRibbonColorDeleteAction): Redirector
    {
        $productRibbonColorDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_ribbon_color.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_ribbon_color.edit', ['model' => $this->model->id]));
    }
}
