<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductCoverImprintColorCreateAction;
use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\FieldEnums\ProductCoverImprintColorFieldEnum;
use Domain\Products\FormGrids\ProductCoverImprintColorFormGrid;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Presets\ProductCoverImprintColorPreset;
use Domain\Products\Rules\ProductCoverImprintColorRules;
use Livewire\Redirector;

class ProductCoverImprintColorCreate extends Form
{
    public string $name = 'product_cover_imprint_color';

    public ProductCoverImprintColor $productCoverImprintColor;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productCoverImprintColor = app(ProductCoverImprintColorPreset::class)();
    }

    public function grids(): array
    {
        return app(ProductCoverImprintColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductCoverImprintColorRules::getRules($this->productCoverImprintColor);
    }

    public function create(ProductCoverImprintColorCreateAction $productCoverImprintColorCreateAction): Redirector|bool
    {
        $this->validate();
        $productCoverImprintColorData = ProductCoverImprintColorData::fromModel($this->productCoverImprintColor);
        $this->productCoverImprintColor = $productCoverImprintColorCreateAction($productCoverImprintColorData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_imprint_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverImprintColorFieldEnum::labels();
    }
}
