<?php

use App\Livewire\Domain\Products\Create\ProductCoverColorCreate;
use App\Livewire\Domain\Products\Edit\ProductCoverColorEdit;
use App\Livewire\Domain\Products\Lists\ProductCoverColorsList;
use Domain\Products\Models\ProductCoverColor;
use function Pest\Livewire\livewire;

//it('loads product_cover_colors list', function () {
//    $this->webActingAs();
//
//    $this->get(route('product_cover_color.list'))
//        ->assertOk()
//        ->assertSeeLivewire(ProductCoverColorsList::class);
//});

it('displays list of product_cover_colors', function () {
    $productCoverColors = ProductCoverColor::factory()->count(20)->create();

    $component = livewire(ProductCoverColorsList::class, [
        'parentModelId' => $productCoverColors->first()->product->id,
    ]);

    expect($component->get('createRoute'))
        ->toBe(route('product_cover_color.create'));

    expect($component->get('rows'))
        ->toHaveCount(1);

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productCoverColors
            ->where('product_id', $productCoverColors->first()->product->id)
            ->pluck('title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('create a productCoverColor', function () {
    $this->webActingAs();

    /** @var ProductCoverColor $productCoverColor */
    $productCoverColor = ProductCoverColor::factory()->make();

    livewire(ProductCoverColorCreate::class, [
        'parentModel' => $productCoverColor->product,
    ])
        ->set('productCoverColor.product_id', $productCoverColor->product_id)
        ->set('productCoverColor.title', $productCoverColor->title)
        ->set('productCoverColor.is_preselected', $productCoverColor->is_preselected)
        ->set('productCoverColor.sort', $productCoverColor->sort)
        ->set('productCoverColor.status', $productCoverColor->status)
        ->call('create');

    $productCoverColorArray = $productCoverColor->toArray();
    unset($productCoverColorArray['label'], $productCoverColorArray['product']);

    $this->assertDatabaseHas('product_cover_colors', $productCoverColorArray);
});

it('update productCoverColor', function () {
    /** @var ProductCoverColor $productCoverColor */
    $productCoverColor = ProductCoverColor::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductCoverColorEdit::class, [
        'model' => $productCoverColor->id,
        'parentModel' => $productCoverColor->product,
    ])
        ->set('productCoverColor.title', 'Title Edited')
        ->call('update');

    $productCoverColor->refresh();

    expect($productCoverColor)
        ->title->toBe('Title Edited');
});
