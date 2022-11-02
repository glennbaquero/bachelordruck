<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductFormatsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductFormatDeleteAction;
use Domain\Products\Actions\ProductFormatUpdateAction;
use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\FieldEnums\ProductFormatFieldEnum;
use Domain\Products\FormGrids\ProductFormatFormGrid;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Rules\ProductFormatRules;
use Livewire\Redirector;

class ProductFormatEdit extends Form
{
    use WithParentModel;

    public string $name = 'productFormat';

    public ProductFormat $productFormat;

    public function mount(ProductFormat $model): void
    {
        $this->productFormat = $model;

        $this->productFormat->product = $this->parentModel;
        $this->productFormat->product_id = $this->parentModel->id;
    }

    public function grids(): array
    {
        return app(ProductFormatFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductFormatRules::getRules($this->productFormat);
    }

    public function update(ProductFormatUpdateAction $productFormatUpdateAction): Redirector|bool
    {
        $this->validate();
        $productFormatData = ProductFormatData::fromModel($this->productFormat);

        unset($this->productFormat->product);

        $this->productFormat = $productFormatUpdateAction($this->productFormat, $productFormatData);
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductFormatsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_format.list'));
    }

    public function delete(ProductFormatDeleteAction $productFormatDeleteAction): Redirector
    {
        $productFormatDeleteAction($this->productFormat);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_format.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductFormatFieldEnum::labels();
    }
}
