<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductBookCornerColorDeleteAction;
use Domain\Products\Actions\ProductBookCornerColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\FieldEnums\ProductBookCornerColorFieldEnum;
use Domain\Products\FormGrids\ProductBookCornerColorFormGrid;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Rules\ProductBookCornerColorRules;
use Livewire\Redirector;

class ProductBookCornerColorEdit extends Form
{
    public string $name = 'productBookCornerColor';

    public ProductBookCornerColor $productBookCornerColor;

    public function mount(ProductBookCornerColor $model): void
    {
        $this->productBookCornerColor = $model;
    }

    public function grids(): array
    {
        return app(ProductBookCornerColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductBookCornerColorRules::getRules($this->productBookCornerColor);
    }

    public function update(ProductBookCornerColorUpdateAction $productBookCornerColorUpdateAction): Redirector
    {
        $this->validate();
        $productBookCornerColorData = ProductBookCornerColorData::fromModel($this->productBookCornerColor);
        $this->productBookCornerColor = $productBookCornerColorUpdateAction($this->productBookCornerColor, $productBookCornerColorData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_book_corner_color.list'));
    }

    public function delete(ProductBookCornerColorDeleteAction $productBookCornerColorDeleteAction): Redirector
    {
        $productBookCornerColorDeleteAction($this->productBookCornerColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('productBookCornerColor.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBookCornerColorFieldEnum::labels();
    }
}
