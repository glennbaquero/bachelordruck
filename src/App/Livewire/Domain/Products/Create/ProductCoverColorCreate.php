<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductCoverColorsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductCoverColorCreateAction;
use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\FieldEnums\ProductCoverColorFieldEnum;
use Domain\Products\FormGrids\ProductCoverColorFormGrid;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Presets\ProductCoverColorPreset;
use Domain\Products\Rules\ProductCoverColorRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductCoverColorCreate extends Form
{
    use WithMedia;
    use WithParentModel;

    public string $name = 'product_cover_color';

    public ProductCoverColor $productCoverColor;

    public string $method = 'create';

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(): void
    {
        $this->productCoverColor = app(ProductCoverColorPreset::class)(new ProductCoverColor(), $this->parentModel);
        $this->uploadModel = $this->productCoverColor;

        $this->productCoverColor->product = $this->parentModel;
        $this->productCoverColor->product_id = $this->parentModel->id;
    }

    public function grids(): array
    {
        return app(ProductCoverColorFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductCoverColorRules::getRules($this->productCoverColor);
    }

    public function create(ProductCoverColorCreateAction $productCoverColorCreateAction): Redirector|bool
    {
        $this->validate();
        $productCoverColorData = ProductCoverColorData::fromModel($this->productCoverColor);
        $this->productCoverColor = $productCoverColorCreateAction($productCoverColorData);
        $this->productCoverColor->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');

        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductCoverColorsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_cover_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverColorFieldEnum::labels();
    }
}
