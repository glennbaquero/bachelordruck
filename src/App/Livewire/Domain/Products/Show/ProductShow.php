<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use App\Livewire\Domain\Products\ShowModals\ProductShowModal;
use Domain\Products\Actions\ProductDeleteAction;
use Domain\Products\Models\Product;
use Domain\Products\ShowGrids\ProductShowGrid;
use Livewire\Redirector;

class ProductShow extends Show
{
    use ProductShowModal;

    public string $name = 'product';

    public Product   $model;

    public function mount(Product $model): void
    {
        $this->model = $model;

        $this->renderModalFromQuery();
    }

    public function grids(): array
    {
        return app(ProductShowGrid::class)();
    }

    public function delete(ProductDeleteAction $productDeleteAction): Redirector
    {
        $productDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product.edit', ['model' => $this->model->id]));
    }
}
