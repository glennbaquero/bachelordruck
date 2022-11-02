<?php

use App\Livewire\Domain\Products\Create\ProductFormatCreate;
use App\Livewire\Domain\Products\Edit\ProductFormatEdit;
use App\Livewire\Domain\Products\Lists\ProductFormatsList;
use Domain\Products\Models\ProductFormat;
use function Pest\Livewire\livewire;

it('displays list of productFormats', function () {
    $productFormats = ProductFormat::factory()->count(20)->create();
    $component = livewire(ProductFormatsList::class, [
        'parentModelId' => $productFormats->first()->product->id,
    ]);

    expect($component->get('createRoute'))
        ->toBe(route('product_format.create'));

    expect($component->get('rows'))
        ->toHaveCount(1);

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productFormats
            ->where('product_id', $productFormats->first()->product->id)
            ->pluck('title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('create a productFormat', function () {
    $this->webActingAs();

    $productFormat = ProductFormat::factory()->make();

    livewire(ProductFormatCreate::class, [
        'parentModel' => $productFormat->product,
    ])
        ->set('productFormat.product_id', $productFormat->product_id)
        ->set('productFormat.title', $productFormat->title)
        ->set('productFormat.is_preselected', $productFormat->is_preselected)
        ->set('productFormat.sort', $productFormat->sort)
        ->set('productFormat.status', $productFormat->status)
        ->call('create');

    $productFormatArray = $productFormat->toArray();
    unset($productFormatArray['label'], $productFormatArray['product']);

    $this->assertDatabaseHas('product_formats', $productFormatArray);
});

it('update productFormat', function () {
    $productFormat = ProductFormat::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductFormatEdit::class, [
        'model' => $productFormat->id,
        'parentModel' => $productFormat->product,
    ])
        ->set('productFormat.title', 'Title Edited')
        ->call('update');

    $productFormat->refresh();

    expect($productFormat)
        ->title->toBe('Title Edited');
});
