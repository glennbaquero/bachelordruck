<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductCoverFoilDeleteAction;
use Domain\Products\Actions\ProductCoverFoilUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\FieldEnums\ProductCoverFoilFieldEnum;
use Domain\Products\FormGrids\ProductCoverFoilFormGrid;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Rules\ProductCoverFoilRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductCoverFoilEdit extends Form
{
    use withMedia;

    public string $name = 'productCoverFoil';

    public ProductCoverFoil $productCoverFoil;

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(ProductCoverFoil $model): void
    {
        $this->productCoverFoil = $model;
        $this->uploadModel = $this->productCoverFoil;
    }

    public function grids(): array
    {
        return app(ProductCoverFoilFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductCoverFoilRules::getRules($this->productCoverFoil);
    }

    public function update(ProductCoverFoilUpdateAction $productCoverFoilUpdateAction): Redirector
    {
        $this->validate();
        $productCoverFoilData = ProductCoverFoilData::fromModel($this->productCoverFoil);
        $this->productCoverFoil = $productCoverFoilUpdateAction($this->productCoverFoil, $productCoverFoilData);
        $this->productCoverFoil->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_foil.list'));
    }

    public function delete(ProductCoverFoilDeleteAction $productCoverFoilDeleteAction): Redirector
    {
        $productCoverFoilDeleteAction($this->productCoverFoil);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_foil.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverFoilFieldEnum::labels();
    }
}
