<?php

namespace App\Livewire\Domain\Products\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductBookSpineColorsList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductBookSpineColorDeleteAction;
use Domain\Products\Actions\ProductBookSpineColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\FieldEnums\ProductBookSpineColorFieldEnum;
use Domain\Products\FormGrids\ProductBookSpineColorFormGrid;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\Rules\ProductBookSpineColorRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class ProductBookSpineColorEdit extends Form
{
    use WithMedia;
    use WithParentModel;

    public string $name = 'productBookSpineColor';

    public ProductBookSpineColor $productBookSpineColor;

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(ProductBookSpineColor $model): void
    {
        $this->productBookSpineColor = $model;
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

    public function update(ProductBookSpineColorUpdateAction $productBookSpineColorUpdateAction): Redirector|bool
    {
        $this->validate();
        $productBookSpineColorData = ProductBookSpineColorData::fromModel($this->productBookSpineColor);

        unset($this->productBookSpineColor->product);

        $this->productBookSpineColor = $productBookSpineColorUpdateAction($this->productBookSpineColor, $productBookSpineColorData);
        $this->productBookSpineColor->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductBookSpineColorsList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_book_spine_color.list'));
    }

    public function delete(ProductBookSpineColorDeleteAction $productBookSpineColorDeleteAction): Redirector
    {
        $productBookSpineColorDeleteAction($this->productBookSpineColor);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_book_spine_color.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBookSpineColorFieldEnum::labels();
    }
}
