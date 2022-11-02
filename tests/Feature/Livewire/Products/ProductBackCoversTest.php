<?php

use App\Livewire\Domain\Products\Create\ProductBackCoverCreate;
use App\Livewire\Domain\Products\Edit\ProductBackCoverEdit;
use App\Livewire\Domain\Products\Lists\ProductBackCoversList;
use App\Livewire\Domain\Products\Show\ProductBackCoverShow;
use Domain\Products\Models\ProductBackCover;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads productBackCovers list', function () {
    $this->webActingAs();

    $this->get(route('product_back_cover.list'))
        ->assertOk()
        ->assertSeeLivewire(ProductBackCoversList::class);
});

it('displays list of productBackCovers', function () {
    $productBackCovers = ProductBackCover::factory()->count(20)->create();
    $component = livewire(ProductBackCoversList::class);

    expect($component->get('createRoute'))
        ->toBe(route('product_back_cover.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Title',
    ]);

    $component->assertSee(
        $productBackCovers
            ->pluck('title') // Change this to a field/column being displayed
            ->splice(0, 10)
            ->all()
    );
});

it('load create productBackCover route', function () {
    $this->webActingAs();

    $this->get(route('product_back_cover.create'))
        ->assertOk()
        ->assertSeeLivewire(ProductBackCoverCreate::class);
});

it('create a productBackCover', function () {
    $this->webActingAs();

    $productBackCover = ProductBackCover::factory()->make();

    livewire(ProductBackCoverCreate::class)
        ->set('productBackCover.title', $productBackCover->title)
        ->set('productBackCover.color', $productBackCover->color)
        ->set('productBackCover.is_preselected', $productBackCover->is_preselected)
        ->set('productBackCover.sort', $productBackCover->sort)
        ->set('productBackCover.status', $productBackCover->status)
        ->call('create')
        ->call('create')
        ->assertRedirect(route('product_back_cover.list'))
        ->assertSessionHas('message');

    $productBackCoverArray = $productBackCover->toArray();
    unset($productBackCoverArray['label']);

    $this->assertDatabaseHas('product_back_covers', $productBackCoverArray);
});

it('shows productBackCover', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productBackCover = ProductBackCover::factory()->create();

    $this->get(route('product_back_cover.show', ['model' => $productBackCover->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductBackCoverShow::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productBackCover->title,
        ]);
});

it('load edit productBackCover route', function () {
    UserLanguageSessionHelper::set('en');
    $this->webActingAs();

    $productBackCover = ProductBackCover::factory()->create();

    $this->get(route('product_back_cover.edit', ['model' => $productBackCover->id]))
        ->assertOk()
        ->assertSeeLivewire(ProductBackCoverEdit::class)
        ->assertSee([
            'title',
        ])
        ->assertSee([
            $productBackCover->title,
        ]);
});

it('update productBackCover', function () {
    $productBackCover = ProductBackCover::factory()->create([
        'title' => 'Title',
    ]);

    livewire(ProductBackCoverEdit::class, ['model' => $productBackCover->id])
        ->set('productBackCover.title', 'Title Edited')
        ->call('update')
        ->assertRedirect(route('product_back_cover.list'))
        ->assertSessionHas('message');

    $productBackCover->refresh();

    expect($productBackCover)
        ->title->toBe('Title Edited');
});
