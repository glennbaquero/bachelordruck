<?php

namespace App\Livewire\Domain\Products\Show;

use App\Livewire\Base\Show;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductPaperThicknessDeleteAction;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\ShowGrids\ProductPaperThicknessShowGrid;
use Livewire\Redirector;

class ProductPaperThicknessShow extends Show
{
    use WithParentModel;

    public string $name = 'product_paper_thickness';

    public ProductPaperThickness $productPaperThickness;

    public function mount(ProductPaperThickness $model): void
    {
        $this->productPaperThickness = $model;
    }

    public function grids(): array
    {
        return app(ProductPaperThicknessShowGrid::class)();
    }

    public function delete(ProductPaperThicknessDeleteAction $productPaperThicknessDeleteAction): Redirector|bool
    {
        $productPaperThicknessDeleteAction($this->productPaperThickness);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_paper_thickness.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('product_paper_thickness.edit', ['model' => $this->productPaperThickness->id]));
    }

    public function getModel()
    {
        return $this->productPaperThickness;
    }
}
