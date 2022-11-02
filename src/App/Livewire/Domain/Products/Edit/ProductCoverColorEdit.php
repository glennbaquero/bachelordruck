<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductCoverColorsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductCoverColorDeleteAction;
use Domain\Products\Actions\ProductCoverColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\FieldEnums\ProductCoverColorFieldEnum;
use Domain\Products\FormGrids\ProductCoverColorFormGrid;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Rules\ProductCoverColorRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductCoverColorEdit extends Form
{
    use WithMedia;
    use WithParentModel;

    public string $name = 'productCoverColor';

    public ProductCoverColor $productCoverColor;

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(ProductCoverColor $model): void
    {
        $this->productCoverColor = $model;
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

    public function update(ProductCoverColorUpdateAction $productCoverColorUpdateAction): Redirector|bool
    {
        $this->validate();
        $productCoverColorData = ProductCoverColorData::fromModel($this->productCoverColor);

        unset($this->productCoverColor->product);

        $this->productCoverColor = $productCoverColorUpdateAction($this->productCoverColor, $productCoverColorData);
        $this->productCoverColor->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductCoverColorsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_cover_color.list'));
    }

    public function delete(ProductCoverColorDeleteAction $productCoverColorDeleteAction): Redirector
    {
        $productCoverColorDeleteAction($this->productCoverColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_cover_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductCoverColorFieldEnum::labels();
    }
}
