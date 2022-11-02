<?php

namespace App\Livewire\Domain\Products\Create;

use App\Livewire\Base\Form;
use App\Livewire\Domain\Products\Lists\ProductPaperThicknessesList;
use App\Livewire\Traits\WithParentModel;
use Domain\Products\Actions\ProductPaperThicknessCreateAction;
use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\FieldEnums\ProductPaperThicknessFieldEnum;
use Domain\Products\FormGrids\ProductPaperThicknessFormGrid;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Presets\ProductPaperThicknessPreset;
use Domain\Products\Rules\ProductPaperThicknessRules;
use Livewire\Redirector;

class ProductPaperThicknessCreate extends Form
{
    use WithParentModel;

    public string $name = 'product_paper_thickness';

    public ProductPaperThickness $productPaperThickness;

    public string $method = 'create';

    public function mount(): void
    {
        $this->productPaperThickness = app(ProductPaperThicknessPreset::class)(new ProductPaperThickness(), $this->parentModel);

        $this->productPaperThickness->product = $this->parentModel;
        $this->productPaperThickness->product_id = $this->parentModel->id;
    }

    public function grids(): array
    {
        return app(ProductPaperThicknessFormGrid::class)();
    }

    public function rules(): array
    {
        return ProductPaperThicknessRules::getRules($this->productPaperThickness);
    }

    public function create(ProductPaperThicknessCreateAction $productPaperThicknessCreateAction): Redirector|bool
    {
        $this->validate();

        $productPaperThicknessData = ProductPaperThicknessData::fromModel($this->productPaperThickness);
        $this->productPaperThickness = $productPaperThicknessCreateAction($productPaperThicknessData);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        if (property_exists($this, 'parentModel')) {
            $this->emitTo(ProductPaperThicknessesList::getName(), 'formSaved');
            $this->emitUp('close');

            return false;
        }

        return redirect()->to(route('product_paper_thickness.list'));
    }

    protected function validationAttributes(): array
    {
        return ProductPaperThicknessFieldEnum::labels();
    }
}
