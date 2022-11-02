<?php

namespace App\Livewire\Bachelordruck;

use App\Livewire\Base\Form;
use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Services\BasketService;
use Domain\Orders\Services\ProductConfigurationDetailsService;
use Domain\Orders\Services\ProductConfigurationService;
use Domain\Products\FieldEnums\ProductConfigurationFieldEnum;
use Domain\Products\Helpers\ProductPriceHelper;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Models\ProductRibbonColor;
use Domain\Products\Rules\ProductConfigurationRules;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Support\Helpers\ArrayHelpers;
use Support\Helpers\Decimals;
use function view;

class ConfigureProduct extends Form
{
    use DefaultLayoutDataTrait;

    public string $name = 'configureProduct';

    public string $language;

    public string $productSlug;

    public ?int $basketId = null;

    public string $newVariantSlug = '';

    public array $productConfiguration = [];

    public array $productCoverColorImages = [];

    public int $quantity = 1;

    public ?int $additionalServiceRequiresCdLabelId;

    public ?int $additionalServiceRequiresCdLabelOptionId;

    protected Product $product;

    protected ?Collection $productCoverImprintColors;

    protected ?Collection $productBookCornerColors;

    protected ?Collection $productRibbonColors;

    protected ?Collection $productCoverFoils;

    protected ?Collection $productBackCovers;

    protected ?Collection $additionalServices;

    public float $price = 0.0;

    protected string $additionalServiceRequiresCdLabelTitle = 'CD brennen mit Labeldruck';

    protected string $additionalServiceRequiresCdLabelOptionTitle = 'Klebehülle für CD';

    public function mount(string $language, string $product, ?int $basketId = null, string $newVariantSlug = ''): void
    {
        $this->ensureSessionIsNew();

        $this->language = $language;
        $this->productSlug = $product;
        $this->basketId = $basketId;

        $this->loadModels();

        $this->setProductConfigurationPreset();
        $this->setAdditionalServiceRequiresCd();
        $this->setProductPaperThicknessPrices();
        $this->setProductCoverColorImages();

        $this->priceShouldUpdate();
    }

    /**
     * Ensure session is new when first time configuring a product.
     *
     * @return void
     */
    protected function ensureSessionIsNew()
    {
        $basketPositions = BasketService::session(session()->getId())->get();

        if ($basketPositions->count() === 0) {
            session()->regenerate();
        }
    }

    protected function loadModels(): void
    {
        if (isset($this->product)) {
            return;
        }

        $product = cache()->rememberForever('products'.$this->productSlug, function () {
            return Product::whereSlug($this->productSlug)->first();
        });

        $this->product = cache()->rememberForever('products'.$product->id, function () use ($product) {
            $product->load([
                'media',
                'activeProductPaperThicknesses',
                'activeProductCoverColors.media',
                'activeProductBookSpineColors',
                'activeProductFormats',
            ]);

            return $product;
        });

        $models = [
            'product_cover_imprint_colors' => ProductCoverImprintColor::class,
            'product_book_corner_colors' => ProductBookCornerColor::class,
            'product_ribbon_colors' => ProductRibbonColor::class,
            'product_back_covers' => ProductBackCover::class,
            'product_cover_foils' => ProductCoverFoil::class,
            'additional_services' => AdditionalService::class,
        ];

        foreach ($models as $tableName => $model) {
            $property = Str::camel($tableName);

            /** @var Model $modelInstance */
            $modelInstance = app($model);

            $this->{$property} = cache()->rememberForever($modelInstance->getTable(), function () use ($modelInstance) {
                return $modelInstance->sortedActive()->get();
            });
        }
    }

    /**
     * @throws UnknownProperties
     */
    protected function setProductConfigurationPreset(): void
    {
        if ($this->basketId) {
            /** @var BasketPosition $basketPosition */
            $basketPosition = BasketPosition::with('product')->find($this->basketId);

            $sourceProduct = $basketPosition->product;

            $sourceConfiguration = new ProductConfigurationData($basketPosition->configuration);

            $productConfigurationDataArray = (new ProductConfigurationService(
                $this->product,
                $this->productCoverImprintColors,
                $this->productBookCornerColors,
                $this->productRibbonColors,
                $this->productCoverFoils,
                $this->productBackCovers,
                $sourceProduct,
                $sourceConfiguration,
            ))->override();

            $productConfigurationData = new ProductConfigurationData($productConfigurationDataArray);

            $this->quantity = $basketPosition->qty;
        } else {
            $productConfigurationDataArray = (new ProductConfigurationService(
                $this->product,
                $this->productCoverImprintColors,
                $this->productBookCornerColors,
                $this->productRibbonColors,
                $this->productCoverFoils,
                $this->productBackCovers,
            ))->default();

            $productConfigurationData = new ProductConfigurationData($productConfigurationDataArray);
        }

        $this->productConfiguration = $productConfigurationData->all();
    }

    protected function setAdditionalServiceRequiresCd(): void
    {
        $this->additionalServiceRequiresCdLabelId = $this->additionalServices
            ->where('title', $this->additionalServiceRequiresCdLabelTitle)
            ->first()?->id;

        $this->additionalServiceRequiresCdLabelOptionId = $this->additionalServices
            ->where('title', $this->additionalServiceRequiresCdLabelOptionTitle)
            ->first()?->id;
    }

    private function selectedProductPaperThickness(): ?ProductPaperThickness
    {
        $this->loadModels();

        /** @var ProductPaperThickness $productPaperThickness */
        return $this->product->activeProductPaperThicknesses->firstWhere('id', $this->productConfiguration['product_paper_thickness_id']);
    }

    private function setProductPaperThicknessPrices(): void
    {
        $productPaperThickness = $this->selectedProductPaperThickness();

        $this->productConfiguration['price_per_page_bw'] = $productPaperThickness?->price_per_page_bw ?? 0;
        $this->productConfiguration['price_per_page_color'] = $productPaperThickness?->price_per_page_color ?? 0;
    }

    public function getCostFormattedProperty(): string
    {
        return Decimals::format($this->cost);
    }

    public function getCostProperty(): float
    {
        return round($this->price * $this->quantity, 2);
    }

    public function updatedProductConfigurationAdditionalServices()
    {
        $this->loadModels();

        if (empty($this->productConfiguration['additional_services'])) {
            $this->productConfiguration['additional_service_surcharges'] = [];

            return;
        }

        $this->productConfiguration['additional_service_surcharges'] = [];

        foreach ($this->productConfiguration['additional_services'] as $additionalServiceId) {
            $this->productConfiguration['additional_service_surcharges'][$additionalServiceId] = $this->additionalServices->firstWhere('id', $additionalServiceId)->surcharge;
        }
    }

    public function updatedProductConfigurationProductPaperThicknessId()
    {
        $this->loadModels();

        $this->setProductPaperThicknessPrices();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'productConfiguration.total_number_of_pages',
            'productConfiguration.number_of_colored_pages',
            'productConfiguration.book_spine_label',
            'quantity',
        ])) {
            $this->validate();
        }
    }

    public function priceShouldUpdate()
    {
        $this->loadModels();

        $this->price = ProductPriceHelper::compute($this->product, new ProductConfigurationData($this->productConfiguration));
    }

    public function order()
    {
        $this->priceShouldUpdate();

        $this->validate();

        if ($this->basketId && ! $this->isNewVariant) {
            $this->updateOrder();
        } else {
            $this->createOrder();
        }

        $this->emit('basketUpdated');
        $this->emit('updateBasketCounter');

        return redirect()->to(route('order.basket-items', [
            'language' => $this->language,
        ]));
    }

    private function createOrder()
    {
        $basketPosition = new BasketPosition([
            'session_id' => session()->getId(),
            'product_id' => $this->product->id,
            'qty' => $this->quantity,
            'price' => $this->price,
        ]);

        $sessionId = session()->getId();

        $this->setBurnToCd();

        $productConfiguration = new ProductConfigurationData($this->productConfiguration);

        $productConfiguration->details = ProductConfigurationDetailsService::make($this->product, $this->quantity, $productConfiguration);

        BasketService::session($sessionId)->add($basketPosition, $productConfiguration);
    }

    private function updateOrder()
    {
        $basketPosition = BasketPosition::find($this->basketId);

        $basketPosition->qty = $this->quantity;
        $basketPosition->price = $this->price;

        $sessionId = session()->getId();

        $this->setBurnToCd();
        $productConfiguration = new ProductConfigurationData($this->productConfiguration);

        $productConfiguration->details = ProductConfigurationDetailsService::make($this->product, $this->quantity, $productConfiguration);

        BasketService::session($sessionId)->update($basketPosition, $productConfiguration);
    }

    private function setBurnToCd()
    {
        $this->productConfiguration['burn_to_cd'] = false;

        if (in_array($this->additionalServiceRequiresCdLabelId, $this->productConfiguration['additional_services'], false)) {
            $this->productConfiguration['burn_to_cd'] = true;
        }
    }

    protected function validationAttributes(): array
    {
        return ArrayHelpers::keyPrepend(ProductConfigurationFieldEnum::labels(), 'productConfiguration.');
    }

    public function rules(): array
    {
        /** @var ProductPaperThickness $productPaperThickness */
        $productPaperThickness = $this->selectedProductPaperThickness();

        return ProductConfigurationRules::getRules($productPaperThickness->max_pages, $this->productConfiguration['total_number_of_pages']);
    }

    public function render(): View
    {
        $this->loadModels();

        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.products.configure', [
            'product' => $this->product,

            'productCoverImprintColors' => $this->productCoverImprintColors,
            'productBookCornerColors' => $this->productBookCornerColors,
            'productRibbonColors' => $this->productRibbonColors,

            'productBackCovers' => $this->productBackCovers,
            'productCoverFoils' => $this->productCoverFoils,

            'additionalServices' => $this->additionalServices,
        ])->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language, [
            'productSlug' => $this->productSlug,
        ]))->slot('livewireContent');
    }

    public function grids(): array
    {
        return [];
    }

    public function getIsNewVariantProperty(): bool
    {
        return $this->newVariantSlug === 'zusatzliche_variante_hinzufugen';
    }

    public function setProductCoverColorImages(): void
    {
        $images = [];

        foreach ($this->product->activeProductCoverColors as $coverColor) {
            $images[$coverColor->id] = $coverColor->getFirstMedia('image')->img()->attributes(['class' => 'cursor-zoom-in lightbox mx-auto w-8/12 sm:6/12 lg:w-10/12'])->toHtml();
        }

        $this->productCoverColorImages = $images;
    }
}
