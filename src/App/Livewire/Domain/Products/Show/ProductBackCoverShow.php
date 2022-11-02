<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use Domain\Products\Actions\ProductBackCoverDeleteAction;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\ShowGrids\ProductBackCoverShowGrid;
use Livewire\Redirector;

class ProductBackCoverShow extends Show
{
    public string $name = 'product_back_cover';

    public ProductBackCover   $model;

    public function mount(ProductBackCover $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(ProductBackCoverShowGrid::class)();
    }

    public function delete(ProductBackCoverDeleteAction $productBackCoverDeleteAction): Redirector
    {
        $productBackCoverDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_back_cover.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_back_cover.edit', ['model' => $this->model->id]));
    }
}
