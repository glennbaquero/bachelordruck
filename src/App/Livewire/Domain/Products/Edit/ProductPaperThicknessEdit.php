<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductPaperThicknessesList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductPaperThicknessDeleteAction;
use Domain\Products\Actions\ProductPaperThicknessUpdateAction;
use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\FieldEnums\ProductPaperThicknessFieldEnum;
use Domain\Products\FormGrids\ProductPaperThicknessFormGrid;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Rules\ProductPaperThicknessRules;
use Livewire\Redirector;

class ProductPaperThicknessEdit extends Form
{
    use WithParentModel;

    public string $name = 'productPaperThickness';

    public ProductPaperThickness $productPaperThickness;

    public function mount(ProductPaperThickness $model): void
    {
        $this->productPaperThickness = $model;

        $this->productPaperThickness->product = $this->parentModel;
        $this->productPaperThickness->product_id = $this->parentModel->id;
    }

    public function grids(): array
    {
        return app(ProductPaperThicknessFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductPaperThicknessRules::getRules($this->productPaperThickness);
    }

    public function update(ProductPaperThicknessUpdateAction $productPaperThicknessUpdateAction): Redirector|bool
    {
        $this->validate();
        $productPaperThicknessData = ProductPaperThicknessData::fromModel($this->productPaperThickness);

        unset($this->productPaperThickness->product);

        $this->productPaperThickness = $productPaperThicknessUpdateAction($this->productPaperThickness, $productPaperThicknessData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductPaperThicknessesList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_paper_thickness.list'));
    }

    public function delete(ProductPaperThicknessDeleteAction $productPaperThicknessDeleteAction): Redirector
    {
        $productPaperThicknessDeleteAction($this->productPaperThickness);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_paper_thickness.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductPaperThicknessFieldEnum::labels();
    }
}
