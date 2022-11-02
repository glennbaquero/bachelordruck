<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductCreateAction;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\FieldEnums\ProductFieldEnum;
use Domain\Products\FormGrids\ProductFormGrid;
use Domain\Products\Models\Product;
use Domain\Products\Presets\ProductPreset;
use Domain\Products\Rules\ProductRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductCreate extends Form
{
    use withMedia;

    public string $name = 'product';

    public Product $product;

    public string $method = 'create';

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(): void
    {
        $this->product = app(ProductPreset::class)();
        $this->avatarModel = $this->product;
        $this->uploadModel = $this->product;
    }

    public function grids(): array
    {
        return app(ProductFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductRules::getRules($this->product);
    }

    public function create(ProductCreateAction $productCreateAction): Redirector
    {
        $this->validate();
        $productData = ProductData::fromModel($this->product);
        $this->product = $productCreateAction($productData);
        $this->product->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product.show', ['model' => $this->product->id]));
    }

    protected function validationAttributes(): array
    {
        return ProductFieldEnum::labels();
    }
}
