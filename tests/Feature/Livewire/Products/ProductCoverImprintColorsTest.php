<?php

use App\Livewire\Domain\Products\Create\ProductCoverImprintColorCreate;
use App\Livewire\Domain\Products\Edit\ProductCoverImprintColorEdit;
use App\Livewire\Domain\Products\Lists\ProductCoverImprintColorsList;
use App\Livewire\Domain\Products\Show\ProductCoverImprintColorShow;
use Domain\Products\Models\ProductCoverImprintColor;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

function hasParent(): bool
{
    return false;
}

it('loads productCoverImprintColors list', function () {
    $this->webActingAs();

    $this->get(route('product_cover_imprint_color.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverImprintColorsList::class);
});

it('displays list of productCoverImprintColors', function () {
    $productCoverImprintColors = ProductCoverImprintColor::factory()->count(20)->create();
    $component = livewire(ProductCoverImprintColorsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product_cover_imprint_color.create'));

    expect($component->get('rows'))
        ->toHaveCount(hasParent() ? 1 : $component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productCoverImprintColors
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create productCoverImprintColor route', function () {
    $this->webActingAs();

    $this->get(route('product_cover_imprint_color.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverImprintColorCreate::class);
});

it('create a productCoverImprintColor', function () {
    $this->webActingAs();

    /** @var ProductCoverImprintColor $productCoverImprintColor */
    $productCoverImprintColor = ProductCoverImprintColor::factory()->make();

    livewire(ProductCoverImprintColorCreate::class)
        ->set('productCoverImprintColor.title', $productCoverImprintColor->title)
        ->set('productCoverImprintColor.color', $productCoverImprintColor->color)
        ->set('productCoverImprintColor.is_preselected', $productCoverImprintColor->is_preselected)
        ->set('productCoverImprintColor.sort', $productCoverImprintColor->sort)
        ->set('productCoverImprintColor.status', $productCoverImprintColor->status)
        ->call('create')
        ->call('create')
        ->assertRedirect(route('product_cover_imprint_color.list'))
        ->assertSessionHas('message');

    $productCoverImprintColorArray = $productCoverImprintColor->toArray();
    unset($productCoverImprintColorArray['label']);

    $this->assertDatabaseHas('product_cover_imprint_colors', $productCoverImprintColorArray);
});

it('shows productCoverImprintColor', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productCoverImprintColor = ProductCoverImprintColor::factory()->create();

    $this->get(route('product_cover_imprint_color.show', ['model' => $productCoverImprintColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverImprintColorShow::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productCoverImprintColor->title,
        ]);
});

it('load edit productCoverImprintColor route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productCoverImprintColor = ProductCoverImprintColor::factory()->create();

    $this->get(route('product_cover_imprint_color.edit', ['model' => $productCoverImprintColor->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductCoverImprintColorEdit::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productCoverImprintColor->title,
        ]);
});

it('update productCoverImprintColor', function () {
    $productCoverImprintColor = ProductCoverImprintColor::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductCoverImprintColorEdit::class, [
        'model' => $productCoverImprintColor->id,
    ])
        ->set('productCoverImprintColor.title', 'Title Edited')
        ->call('update')
        ->assertRedirect(route('product_cover_imprint_color.list'))
        ->assertSessionHas('message');

    $productCoverImprintColor->refresh();

    expect($productCoverImprintColor)
        ->title->toBe('Title Edited');
});
