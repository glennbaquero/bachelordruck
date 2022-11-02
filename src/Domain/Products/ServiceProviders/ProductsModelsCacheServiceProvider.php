<?php

namespace Domain\Products\ServiceProviders;

use Domain\Products\Models\AdditionalService;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Models\ProductRibbonColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class ProductsModelsCacheServiceProvider extends ServiceProvider
{
    private array $productCacheableModels = [
        Product::class,
        ProductPaperThickness::class,
        ProductCoverColor::class,
        ProductBookSpineColor::class,
        ProductFormat::class,
    ];

    private array $otherCacheableModels = [
        ProductCoverImprintColor::class,
        ProductBookCornerColor::class,
        ProductRibbonColor::class,
        ProductBackCover::class,
        ProductCoverFoil::class,
        AdditionalService::class,
    ];

    public function boot()
    {
        foreach ($this->productCacheableModels as $cacheableModel) {
            $cacheableModel::saved(function (Model $model) {
                if ($model->getTable() === 'products') {
                    cache()->forget($model->getTable().$model->id);
                    cache()->forget($model->getTable().$model->slug);
                } else {
                    cache()->forget($model->getTable().$model->product_id);
                }
            });

            $cacheableModel::deleted(function (Model $model) {
                if ($model->getTable() === 'products') {
                    cache()->forget($model->getTable().$model->id);
                    cache()->forget($model->getTable().$model->slug);
                } else {
                    cache()->forget($model->getTable().$model->product_id);
                }
            });
        }

        foreach ($this->otherCacheableModels as $cacheableModel) {
            $cacheableModel::saved(function (Model $model) {
                cache()->forget($model->getTable());
            });

            $cacheableModel::deleted(function (Model $model) {
                cache()->forget($model->getTable());
            });
        }
    }
}
