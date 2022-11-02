<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductBookCornerColorCreateAction;
use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\FieldEnums\ProductBookCornerColorFieldEnum;
use Domain\Products\FormGrids\ProductBookCornerColorFormGrid;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Presets\ProductBookCornerColorPreset;
use Domain\Products\Rules\ProductBookCornerColorRules;
use Livewire\Redirector;

class ProductBookCornerColorCreate extends Form
{
    public string $name = 'product_book_corner_color';

    public ProductBookCornerColor $productBookCornerColor;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productBookCornerColor = app(ProductBookCornerColorPreset::class)();
        $this->avatarModel = $this->productBookCornerColor;
    }

    public function grids(): array
    {
        return app(ProductBookCornerColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductBookCornerColorRules::getRules($this->productBookCornerColor);
    }

    public function create(ProductBookCornerColorCreateAction $productBookCornerColorCreateAction): Redirector
    {
        $this->validate();
        $productBookCornerColorData = ProductBookCornerColorData::fromModel($this->productBookCornerColor);
        $this->productBookCornerColor = $productBookCornerColorCreateAction($productBookCornerColorData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_book_corner_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBookCornerColorFieldEnum::labels();
    }
}
