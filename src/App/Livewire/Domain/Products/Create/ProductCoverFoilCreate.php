<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductCoverFoilCreateAction;
use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\FieldEnums\ProductCoverFoilFieldEnum;
use Domain\Products\FormGrids\ProductCoverFoilFormGrid;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Presets\ProductCoverFoilPreset;
use Domain\Products\Rules\ProductCoverFoilRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductCoverFoilCreate extends Form
{
    use withMedia;

    public string $name = 'product_cover_foil';

    public ProductCoverFoil $productCoverFoil;

    public string $method = 'create';

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(): void
    {
        $this->productCoverFoil = app(ProductCoverFoilPreset::class)();
        $this->avatarModel = $this->productCoverFoil;
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

    public function create(ProductCoverFoilCreateAction $productCoverFoilCreateAction): Redirector
    {
        $this->validate();
        $productCoverFoilData = ProductCoverFoilData::fromModel($this->productCoverFoil);
        $this->productCoverFoil = $productCoverFoilCreateAction($productCoverFoilData);
        $this->productCoverFoil->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_foil.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverFoilFieldEnum::labels();
    }
}
