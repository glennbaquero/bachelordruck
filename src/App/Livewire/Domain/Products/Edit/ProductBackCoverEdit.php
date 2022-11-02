<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductBackCoverDeleteAction;
use Domain\Products\Actions\ProductBackCoverUpdateAction;
use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\FieldEnums\ProductBackCoverFieldEnum;
use Domain\Products\FormGrids\ProductBackCoverFormGrid;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Rules\ProductBackCoverRules;
use Livewire\Redirector;

class ProductBackCoverEdit extends Form
{
    public string $name = 'productBackCover';

    public ProductBackCover $productBackCover;

    public function mount(ProductBackCover $model): void
    {
        $this->productBackCover = $model;
    }

    public function grids(): array
    {
        return app(ProductBackCoverFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductBackCoverRules::getRules($this->productBackCover);
    }

    public function update(ProductBackCoverUpdateAction $productBackCoverUpdateAction): Redirector
    {
        $this->validate();
        $productBackCoverData = ProductBackCoverData::fromModel($this->productBackCover);
        $this->productBackCover = $productBackCoverUpdateAction($this->productBackCover, $productBackCoverData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_back_cover.list'));
    }

    public function delete(ProductBackCoverDeleteAction $productBackCoverDeleteAction): Redirector
    {
        $productBackCoverDeleteAction($this->productBackCover);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('productBackCover.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBackCoverFieldEnum::labels();
    }
}
