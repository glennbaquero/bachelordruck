<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductFormatDeleteAction;
use Domain\Products\Models\ProductFormat;
use Domain\Products\ShowGrids\ProductFormatShowGrid;
use Livewire\Redirector;

class ProductFormatShow extends Show
{
    use WithParentModel;

    public string $name = 'product_format';

    public ProductFormat $productFormat;

    public function mount(ProductFormat $model): void
    {
        $this->productFormat = $model;
    }

    public function grids(): array
    {
        return app(ProductFormatShowGrid::class)();
    }

    public function delete(ProductFormatDeleteAction $productFormatDeleteAction): Redirector
    {
        $productFormatDeleteAction($this->productFormat);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_format.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_format.edit', ['model' => $this->productFormat->id]));
    }

    public function getModel()
    {
        return $this->productFormat;
    }
}
