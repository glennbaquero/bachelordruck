<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\ProductCoverFoilDeleteAction;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\ShowGrids\ProductCoverFoilShowGrid;
use Livewire\Redirector;

class ProductCoverFoilShow extends Show
{
    public string $name = 'product_cover_foil';

    public ProductCoverFoil   $model;

    public function mount(ProductCoverFoil $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(ProductCoverFoilShowGrid::class)();
    }

    public function delete(ProductCoverFoilDeleteAction $productCoverFoilDeleteAction): Redirector
    {
        $productCoverFoilDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_foil.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_cover_foil.edit', ['model' => $this->model->id]));
    }
}
