<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductDeleteAction;
use Domain\Products\Actions\ProductUpdateAction;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\FieldEnums\ProductFieldEnum;
use Domain\Products\FormGrids\ProductFormGrid;
use Domain\Products\Models\Product;
use Domain\Products\Rules\ProductRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductEdit extends Form
{
    use withMedia;

    public string $name = 'product';

    public Product $product;

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(Product $model): void
    {
        $this->product = $model;
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

    public function update(ProductUpdateAction $productUpdateAction): Redirector
    {
        $this->validate();
        $productData = ProductData::fromModel($this->product);
        $this->product = $productUpdateAction($this->product, $productData);
        $this->product->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product.list'));
    }

    public function delete(ProductDeleteAction $productDeleteAction): Redirector
    {
        $productDeleteAction($this->product);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductFieldEnum::labels();
    }
}
