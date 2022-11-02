<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductCoverImprintColorDeleteAction;
use Domain\Products\Actions\ProductCoverImprintColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\FieldEnums\ProductCoverImprintColorFieldEnum;
use Domain\Products\FormGrids\ProductCoverImprintColorFormGrid;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Rules\ProductCoverImprintColorRules;
use Livewire\Redirector;

class ProductCoverImprintColorEdit extends Form
{
    public string $name = 'product_cover_imprint_color';

    public ProductCoverImprintColor $productCoverImprintColor;

    public function mount(ProductCoverImprintColor $model): void
    {
        $this->productCoverImprintColor = $model;
    }

    public function grids(): array
    {
        return app(ProductCoverImprintColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductCoverImprintColorRules::getRules($this->productCoverImprintColor);
    }

    public function update(ProductCoverImprintColorUpdateAction $productCoverImprintColorUpdateAction): Redirector|bool
    {
        $this->validate();
        $productCoverImprintColorData = ProductCoverImprintColorData::fromModel($this->productCoverImprintColor);
        $this->productCoverImprintColor = $productCoverImprintColorUpdateAction($this->productCoverImprintColor, $productCoverImprintColorData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_imprint_color.list'));
    }

    public function delete(ProductCoverImprintColorDeleteAction $productCoverImprintColorDeleteAction): Redirector
    {
        $productCoverImprintColorDeleteAction($this->productCoverImprintColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('productCoverImprintColor.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverImprintColorFieldEnum::labels();
    }
}
