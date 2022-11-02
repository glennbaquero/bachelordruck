<?php

use App\Livewire\Domain\Products\Create\ProductPaperThicknessCreate;
use App\Livewire\Domain\Products\Edit\ProductPaperThicknessEdit;
use App\Livewire\Domain\Products\Lists\ProductPaperThicknessesList;
use Domain\Products\Models\ProductPaperThickness;
use function Pest\Livewire\livewire;

it('displays list of productPaperThicknesses', function () {
    $productPaperThicknesses = ProductPaperThickness::factory()->count(20)->create();

    $component = livewire(ProductPaperThicknessesList::class, [
        'parentModelId' => $productPaperThicknesses->first()->product->id,
    ]);

    expect($component->get('createRoute'))
        ->toBe(route('product_paper_thickness.create'));

    expect($component->get('rows'))
        ->toHaveCount(1);

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productPaperThicknesses
            ->where('product_id', $productPaperThicknesses->first()->product->id)
            ->pluck('Title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('create a productPaperThickness', function () {
    $this->webActingAs();

    $productPaperThickness = ProductPaperThickness::factory()->make();

    livewire(ProductPaperThicknessCreate::class, [
        'parentModel' => $productPaperThickness->product,
    ])
        ->set('productPaperThickness.product_id', $productPaperThickness->product_id)
        ->set('productPaperThickness.title', $productPaperThickness->title)
        ->set('productPaperThickness.tooltip', $productPaperThickness->tooltip)
        ->set('productPaperThickness.max_pages', $productPaperThickness->max_pages)
        ->set('productPaperThickness.price_per_page_bw', $productPaperThickness->price_per_page_bw)
        ->set('productPaperThickness.price_per_page_color', $productPaperThickness->price_per_page_color)
        ->set('productPaperThickness.is_preselected', $productPaperThickness->is_preselected)
        ->set('productPaperThickness.sort', $productPaperThickness->sort)
        ->set('productPaperThickness.status', $productPaperThickness->status)
        ->call('create');

    $productPaperThicknessArray = $productPaperThickness->toArray();

    $productPaperThicknessArray['price_per_page_bw'] *= 100;
    $productPaperThicknessArray['price_per_page_color'] *= 100;

    unset($productPaperThicknessArray['label'], $productPaperThicknessArray['product']);

    $this->assertDatabaseHas('product_paper_thicknesses', $productPaperThicknessArray);
});

it('update productPaperThickness', function () {
    $productPaperThickness = ProductPaperThickness::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductPaperThicknessEdit::class, [
        'model' => $productPaperThickness->id,
        'parentModel' => $productPaperThickness->product,
    ])
        ->set('productPaperThickness.title', 'Title Edited')
        ->call('update');

    $productPaperThickness->refresh();

    expect($productPaperThickness)
        ->title->toBe('Title Edited');
});
