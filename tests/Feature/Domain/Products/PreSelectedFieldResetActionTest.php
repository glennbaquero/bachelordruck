<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\PreSelectedFieldResetAction;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Models\ProductRibbonColor;

it('reset pre-selected field without parent', function () {
    /** @var ProductRibbonColor $productRibbonColor1 */
    $productRibbonColor1 = ProductRibbonColor::factory()->create([
        'is_preselected' => true,
    ]);

    /** @var ProductRibbonColor $productRibbonColor2 */
    $productRibbonColor2 = ProductRibbonColor::factory()->create([
        'is_preselected' => true,
    ]);

    app(PreSelectedFieldResetAction::class)($productRibbonColor2, $productRibbonColor2->is_preselected);

    $productRibbonColor1->refresh();

    expect($productRibbonColor1)
        ->is_preselected->toBeFalse();

    $productRibbonColor2->refresh();

    expect($productRibbonColor2)
        ->is_preselected->toBeTrue();
});

it('reset pre-selected field with parent', function () {
    /** @var Product $product1 */
    $product1 = Product::factory()->create();

    /** @var ProductCoverColor $productCoverColor1 */
    $productCoverColor1 = ProductCoverColor::factory()->create([
        'product_id' => $product1->id,
        'is_preselected' => true,
    ]);

    /** @var ProductCoverColor $productCoverColor2 */
    $productCoverColor2 = ProductCoverColor::factory()->create([
        'product_id' => $product1->id,
        'is_preselected' => true,
    ]);

    /** @var Product $product2 */
    $product2 = Product::factory()->create();

    /** @var ProductCoverColor $productCoverColor3 */
    $productCoverColor3 = ProductCoverColor::factory()->create([
        'product_id' => $product2->id,
        'is_preselected' => true,
    ]);

    app(PreSelectedFieldResetAction::class)($productCoverColor2, $productCoverColor2->is_preselected, 'product_id');

    $productCoverColor1->refresh();

    expect($productCoverColor1)
        ->is_preselected->toBeFalse();

    $productCoverColor2->refresh();

    expect($productCoverColor2)
        ->is_preselected->toBeTrue();

    $productCoverColor3->refresh();

    expect($productCoverColor3)
        ->is_preselected->toBeTrue();
});
