<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductRibbonColorDeleteAction;
use Domain\Products\Actions\ProductRibbonColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\FieldEnums\ProductRibbonColorFieldEnum;
use Domain\Products\FormGrids\ProductRibbonColorFormGrid;
use Domain\Products\Models\ProductRibbonColor;
use Domain\Products\Rules\ProductRibbonColorRules;
use Livewire\Redirector;

class ProductRibbonColorEdit extends Form
{
    public string $name = 'productRibbonColor';

    public ProductRibbonColor $productRibbonColor;

    public function mount(ProductRibbonColor $model): void
    {
        $this->productRibbonColor = $model;
    }

    public function grids(): array
    {
        return app(ProductRibbonColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductRibbonColorRules::getRules($this->productRibbonColor);
    }

    public function update(ProductRibbonColorUpdateAction $productRibbonColorUpdateAction): Redirector
    {
        $this->validate();
        $productRibbonColorData = ProductRibbonColorData::fromModel($this->productRibbonColor);
        $this->productRibbonColor = $productRibbonColorUpdateAction($this->productRibbonColor, $productRibbonColorData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_ribbon_color.list'));
    }

    public function delete(ProductRibbonColorDeleteAction $productRibbonColorDeleteAction): Redirector
    {
        $productRibbonColorDeleteAction($this->productRibbonColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_ribbon_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductRibbonColorFieldEnum::labels();
    }
}
