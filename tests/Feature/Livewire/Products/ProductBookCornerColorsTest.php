<?php

use App\Livewire\Domain\Products\Create\ProductBookCornerColorCreate;
use App\Livewire\Domain\Products\Edit\ProductBookCornerColorEdit;
use App\Livewire\Domain\Products\Lists\ProductBookCornerColorsList;
use App\Livewire\Domain\Products\Show\ProductBookCornerColorShow;
use Domain\Products\Models\ProductBookCornerColor;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads productBookCornerColors list', function () {
    $this->webActingAs();

    $this->get(route('product_book_corner_color.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductBookCornerColorsList::class);
});

it('displays list of productBookCornerColors', function () {
    $productBookCornerColors = ProductBookCornerColor::factory()->count(20)->create();
    $component = livewire(ProductBookCornerColorsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product_book_corner_color.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productBookCornerColors
            ->pluck('title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('load create productBookCornerColor route', function () {
    $this->webActingAs();

    $this->get(route('product_book_corner_color.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductBookCornerColorCreate::class);
});

it('create a productBookCornerColor', function () {
    $this->webActingAs();

    $productBookCornerColor = ProductBookCornerColor::factory()->make();

    livewire(ProductBookCornerColorCreate::class)
        ->set('productBookCornerColor.title', $productBookCornerColor->title)
        ->set('productBookCornerColor.color', $productBookCornerColor->color)
        ->set('productBookCornerColor.is_preselected', $productBookCornerColor->is_preselected)
        ->set('productBookCornerColor.sort', $productBookCornerColor->sort)
        ->set('productBookCornerColor.status', $productBookCornerColor->status)
        ->call('create')
        ->call('create')
        ->assertRedirect(route('product_book_corner_color.list'))
        ->assertSessionHas('message');

    $productBookCornerColorArray = $productBookCornerColor->toArray();
    unset($productBookCornerColorArray['label']);

    $this->assertDatabaseHas('product_book_corner_colors', $productBookCornerColorArray);
});

it('shows productBookCornerColor', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productBookCornerColor = ProductBookCornerColor::factory()->create();

    $this->get(route('product_book_corner_color.show', ['model' => $productBookCornerColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductBookCornerColorShow::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productBookCornerColor->title,
        ]);
});

it('load edit productBookCornerColor route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productBookCornerColor = ProductBookCornerColor::factory()->create();

    $this->get(route('product_book_corner_color.edit', ['model' => $productBookCornerColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductBookCornerColorEdit::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productBookCornerColor->title,
        ]);
});

it('update productBookCornerColor', function () {
    $productBookCornerColor = ProductBookCornerColor::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductBookCornerColorEdit::class, ['model' => $productBookCornerColor->id])
        ->set('productBookCornerColor.title', 'Title Edited')
        ->call('update')
        ->assertRedirect(route('product_book_corner_color.list'))
        ->assertSessionHas('message');

    $productBookCornerColor->refresh();

    expect($productBookCornerColor)
        ->title->toBe('Title Edited');
});
