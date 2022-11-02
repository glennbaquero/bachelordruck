<?php

use App\Livewire\Domain\Products\Create\ProductBookSpineColorCreate;
use App\Livewire\Domain\Products\Edit\ProductBookSpineColorEdit;
use App\Livewire\Domain\Products\Lists\ProductBookSpineColorsList;
use Domain\Products\Models\ProductBookSpineColor;
use function Pest\Livewire\livewire;

it('displays list of productBookSpineColors', function () {
    $productBookSpineColors = ProductBookSpineColor::factory()->count(20)->create();
    $component = livewire(ProductBookSpineColorsList::class, [
        'parentModelId' => $productBookSpineColors->first()->product->id,
    ]);

    expect($component->get('createRoute'))
        ->toBe(route('product_book_spine_color.create'));

    expect($component->get('rows'))
        ->toHaveCount(1);

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productBookSpineColors
            ->where('product_id', $productBookSpineColors->first()->product->id)
            ->pluck('title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('create a productBookSpineColor', function () {
    $this->webActingAs();

    $productBookSpineColor = ProductBookSpineColor::factory()->make();

    livewire(ProductBookSpineColorCreate::class, [
        'parentModel' => $productBookSpineColor->product,
    ])
        ->set('productBookSpineColor.product_id', $productBookSpineColor->product_id)
        ->set('productBookSpineColor.title', $productBookSpineColor->title)
        ->set('productBookSpineColor.color', $productBookSpineColor->color)
        ->set('productBookSpineColor.is_preselected', $productBookSpineColor->is_preselected)
        ->set('productBookSpineColor.sort', $productBookSpineColor->sort)
        ->set('productBookSpineColor.status', $productBookSpineColor->status)
        ->call('create');

    $productBookSpineColorArray = $productBookSpineColor->toArray();
    unset($productBookSpineColorArray['label'], $productBookSpineColorArray['product']);

    $this->assertDatabaseHas('product_book_spine_colors', $productBookSpineColorArray);
});

it('update productBookSpineColor', function () {
    $productBookSpineColor = ProductBookSpineColor::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductBookSpineColorEdit::class, [
        'model' => $productBookSpineColor->id,
        'parentModel' => $productBookSpineColor->product,
    ])
        ->set('productBookSpineColor.title', 'Title Edited')
        ->call('update');

    $productBookSpineColor->refresh();

    expect($productBookSpineColor)
        ->title->toBe('Title Edited');
});
