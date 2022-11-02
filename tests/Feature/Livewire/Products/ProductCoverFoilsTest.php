<?php

use App\Livewire\Domain\Products\Create\ProductCoverFoilCreate;
use App\Livewire\Domain\Products\Edit\ProductCoverFoilEdit;
use App\Livewire\Domain\Products\Lists\ProductCoverFoilsList;
use App\Livewire\Domain\Products\Show\ProductCoverFoilShow;
use Domain\Products\Models\ProductCoverFoil;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads productCoverFoils list', function () {
    $this->webActingAs();

    $this->get(route('product_cover_foil.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverFoilsList::class);
});

it('displays list of productCoverFoils', function () {
    $productCoverFoils = ProductCoverFoil::factory()->count(20)->create();
    $component = livewire(ProductCoverFoilsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product_cover_foil.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productCoverFoils
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create productCoverFoil route', function () {
    $this->webActingAs();

    $this->get(route('product_cover_foil.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverFoilCreate::class);
});

it('create a productCoverFoil', function () {
    $this->webActingAs();

    $productCoverFoil = ProductCoverFoil::factory()->make();

    livewire(ProductCoverFoilCreate::class)
        ->set('productCoverFoil.title', $productCoverFoil->title)
        ->set('productCoverFoil.is_preselected', $productCoverFoil->is_preselected)
        ->set('productCoverFoil.sort', $productCoverFoil->sort)
        ->set('productCoverFoil.status', $productCoverFoil->status)
        ->call('create')
        ->assertRedirect(route('product_cover_foil.list'))
        ->assertSessionHas('message');

    $productCoverFoilArray = $productCoverFoil->toArray();
    unset($productCoverFoilArray['label']);

    $this->assertDatabaseHas('product_cover_foils', $productCoverFoilArray);
});

it('shows productCoverFoil', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productCoverFoil = ProductCoverFoil::factory()->create();

    $this->get(route('product_cover_foil.show', ['model' => $productCoverFoil->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverFoilShow::class)
        ->assertSee([
            'Title',
        ])
        ->assertSee([
            $productCoverFoil->title,
        ]);
});

it('load edit productCoverFoil route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productCoverFoil = ProductCoverFoil::factory()->create();

    $this->get(route('product_cover_foil.edit', ['model' => $productCoverFoil->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverFoilEdit::class)
        ->assertSee([
            'Title',
        ])
        ->assertSee([
            $productCoverFoil->title,
        ]);
});

it('update productCoverFoil', function () {
    $productCoverFoil = ProductCoverFoil::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductCoverFoilEdit::class, ['model' => $productCoverFoil->id])
        ->set('productCoverFoil.title', 'Title Edited')
        ->call('update')
        ->assertRedirect(route('product_cover_foil.list'))
        ->assertSessionHas('message');

    $productCoverFoil->refresh();

    expect($productCoverFoil)
        ->title->toBe('Title Edited');
});
