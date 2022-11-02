<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductCoverColorDeleteAction;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\ShowGrids\ProductCoverColorShowGrid;
use Livewire\Redirector;

class ProductCoverColorShow extends Show
{
    use WithParentModel;

    public string $name = 'productCoverColor';

    public ProductCoverColor $productCoverColor;

    public function mount(ProductCoverColor $model): void
    {
        $this->productCoverColor = $model;
    }

    public function grids(): array
    {
        return app(ProductCoverColorShowGrid::class)();
    }

    public function delete(ProductCoverColorDeleteAction $productCoverColorDeleteAction): Redirector
    {
        $productCoverColorDeleteAction($this->productCoverColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('productCoverColor.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('productCoverColor.edit', ['model' => $this->productCoverColor->id]));
    }

    public function getModel()
    {
        return $this->productCoverColor;
    }
}
