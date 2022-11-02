<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductFormatsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductFormatCreateAction;
use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\FieldEnums\ProductFormatFieldEnum;
use Domain\Products\FormGrids\ProductFormatFormGrid;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Presets\ProductFormatPreset;
use Domain\Products\Rules\ProductFormatRules;
use Livewire\Redirector;

class ProductFormatCreate extends Form
{
    use WithParentModel;

    public string $name = 'product_format';

    public ProductFormat $productFormat;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productFormat = app(ProductFormatPreset::class)(new ProductFormat(), $this->parentModel);

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

    public function create(ProductFormatCreateAction $productFormatCreateAction): Redirector|bool
    {
        $this->validate();
        $productFormatData = ProductFormatData::fromModel($this->productFormat);
        $this->productFormat = $productFormatCreateAction($productFormatData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductFormatsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_format.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductFormatFieldEnum::labels();
    }
}
