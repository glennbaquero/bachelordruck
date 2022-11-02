<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\ProductCoverImprintColorDeleteAction;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\ShowGrids\ProductCoverImprintColorShowGrid;
use Livewire\Redirector;

class ProductCoverImprintColorShow extends Show
{
    public string $name = 'product_cover_imprint_color';

    public ProductCoverImprintColor $productCoverImprintColor;

    public function mount(ProductCoverImprintColor $model): void
    {
        $this->productCoverImprintColor = $model;
    }

    public function grids(): array
    {
        return app(ProductCoverImprintColorShowGrid::class)();
    }

    public function delete(ProductCoverImprintColorDeleteAction $productCoverImprintColorDeleteAction): Redirector
    {
        $productCoverImprintColorDeleteAction($this->productCoverImprintColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_imprint_color.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('productCoverImprintColor.edit', ['model' => $this->productCoverImprintColor->id]));
    }

    public function getModel()
    {
        return $this->productCoverImprintColor;
    }
}
