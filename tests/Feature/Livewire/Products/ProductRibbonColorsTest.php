<?php

use App\Livewire\Domain\Products\Create\ProductRibbonColorCreate;
use App\Livewire\Domain\Products\Edit\ProductRibbonColorEdit;
use App\Livewire\Domain\Products\Lists\ProductRibbonColorsList;
use App\Livewire\Domain\Products\Show\ProductRibbonColorShow;
use Domain\Products\Models\ProductRibbonColor;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads productRibbonColors list', function () {
    $this->webActingAs();

    $this->get(route('product_ribbon_color.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductRibbonColorsList::class);
});

it('displays list of productRibbonColors', function () {
    $productRibbonColors = ProductRibbonColor::factory()->count(20)->create();
    $component = livewire(ProductRibbonColorsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product_ribbon_color.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productRibbonColors
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create productRibbonColor route', function () {
    $this->webActingAs();

    $this->get(route('product_ribbon_color.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductRibbonColorCreate::class);
});

it('create a productRibbonColor', function () {
    $this->webActingAs();

    $productRibbonColor = ProductRibbonColor::factory()->make();

    livewire(ProductRibbonColorCreate::class)
        ->set('productRibbonColor.title', $productRibbonColor->title)
        ->set('productRibbonColor.color', $productRibbonColor->color)
        ->set('productRibbonColor.is_preselected', $productRibbonColor->is_preselected)
        ->set('productRibbonColor.sort', $productRibbonColor->sort)
        ->set('productRibbonColor.status', $productRibbonColor->status)
        ->call('create')
        ->call('create')
        ->assertRedirect(route('product_ribbon_color.list'))
        ->assertSessionHas('message');

    $productRibbonColorArray = $productRibbonColor->toArray();
    unset($productRibbonColorArray['label']);

    $this->assertDatabaseHas('product_ribbon_colors', $productRibbonColorArray);
});

it('shows productRibbonColor', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productRibbonColor = ProductRibbonColor::factory()->create();

    $this->get(route('product_ribbon_color.show', ['model' => $productRibbonColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductRibbonColorShow::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productRibbonColor->title,
        ]);
});

it('load edit productRibbonColor route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productRibbonColor = ProductRibbonColor::factory()->create();

    $this->get(route('product_ribbon_color.edit', ['model' => $productRibbonColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductRibbonColorEdit::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productRibbonColor->title,
        ]);
});

it('update productRibbonColor', function () {
    $productRibbonColor = ProductRibbonColor::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductRibbonColorEdit::class, ['model' => $productRibbonColor->id])
        ->set('productRibbonColor.title', 'Title Edited')
        ->call('update')
        ->assertRedirect(route('product_ribbon_color.list'))
        ->assertSessionHas('message');

    $productRibbonColor->refresh();

    expect($productRibbonColor)
        ->title->toBe('Title Edited');
});
