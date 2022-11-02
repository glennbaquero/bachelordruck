<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use Domain\Products\Actions\ProductBackCoverCreateAction;
use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\FieldEnums\ProductBackCoverFieldEnum;
use Domain\Products\FormGrids\ProductBackCoverFormGrid;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Presets\ProductBackCoverPreset;
use Domain\Products\Rules\ProductBackCoverRules;
use Livewire\Redirector;

class ProductBackCoverCreate extends Form
{
    public string $name = 'product_back_cover';

    public ProductBackCover $productBackCover;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productBackCover = app(ProductBackCoverPreset::class)();
        $this->avatarModel = $this->productBackCover;
    }

    public function grids(): array
    {
        return app(ProductBackCoverFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductBackCoverRules::getRules($this->productBackCover);
    }

    public function create(ProductBackCoverCreateAction $productBackCoverCreateAction): Redirector
    {
        $this->validate();
        $productBackCoverData = ProductBackCoverData::fromModel($this->productBackCover);
        $this->productBackCover = $productBackCoverCreateAction($productBackCoverData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('product_back_cover.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductBackCoverFieldEnum::labels();
    }
}
