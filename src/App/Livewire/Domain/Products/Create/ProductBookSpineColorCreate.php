<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductBookSpineColorsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductBookSpineColorCreateAction;
use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\FieldEnums\ProductBookSpineColorFieldEnum;
use Domain\Products\FormGrids\ProductBookSpineColorFormGrid;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\Presets\ProductBookSpineColorPreset;
use Domain\Products\Rules\ProductBookSpineColorRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductBookSpineColorCreate extends Form
{
    use WithMedia;
    use WithParentModel;

    public string $name = 'product_book_spine_color';

    public ProductBookSpineColor $productBookSpineColor;

    public string $method = 'create';

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(): void
    {
        $this->productBookSpineColor = app(ProductBookSpineColorPreset::class)(new ProductBookSpineColor(), $this->parentModel);
        $this->uploadModel = $this->productBookSpineColor;

        $this->productBookSpineColor->product = $this->parentModel;
        $this->productBookSpineColor->product_id = $this->parentModel->id;
    }

    public function grids(): array
    {
        return app(ProductBookSpineColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductBookSpineColorRules::getRules($this->productBookSpineColor);
    }

    public function create(ProductBookSpineColorCreateAction $productBookSpineColorCreateAction): Redirector|bool
    {
        $this->validate();
        $productBookSpineColorData = ProductBookSpineColorData::fromModel($this->productBookSpineColor);
        $this->productBookSpineColor = $productBookSpineColorCreateAction($productBookSpineColorData);
        $this->productBookSpineColor->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductBookSpineColorsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_book_spine_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBookSpineColorFieldEnum::labels();
    }
}
