<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductRibbonColorCreateAction;
use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\FieldEnums\ProductRibbonColorFieldEnum;
use Domain\Products\FormGrids\ProductRibbonColorFormGrid;
use Domain\Products\Models\ProductRibbonColor;
use Domain\Products\Presets\ProductRibbonColorPreset;
use Domain\Products\Rules\ProductRibbonColorRules;
use Livewire\Redirector;

class ProductRibbonColorCreate extends Form
{
    public string $name = 'product_ribbon_color';

    public ProductRibbonColor $productRibbonColor;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productRibbonColor = app(ProductRibbonColorPreset::class)();
        $this->avatarModel = $this->productRibbonColor;
    }

    public function grids(): array
    {
        return app(ProductRibbonColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductRibbonColorRules::getRules($this->productRibbonColor);
    }

    public function create(ProductRibbonColorCreateAction $productRibbonColorCreateAction): Redirector
    {
        $this->validate();
        $productRibbonColorData = ProductRibbonColorData::fromModel($this->productRibbonColor);
        $this->productRibbonColor = $productRibbonColorCreateAction($productRibbonColorData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_ribbon_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductRibbonColorFieldEnum::labels();
    }
}
