<?php

use App\Livewire\Domain\Galleries\Create\GalleryCreate;
use App\Livewire\Domain\Galleries\Edit\GalleryEdit;
use App\Livewire\Domain\Galleries\Lists\GalleryList;
use App\Livewire\Domain\Galleries\Show\GalleryShow;
use Domain\Galleries\Models\Gallery;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads gallery list', function () {
    $this->webActingAs();

    $this->get(route('gallery.list'))
        ->assertOk()
        ->assertSeeLivewire(GalleryList::class);
});

it('displays list of gallery', function () {
    $gallery = Gallery::factory()->count(20)->create();

    $component = livewire(GalleryList::class);

    expect($component->get('createRoute'))
        ->toBe(route('gallery.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([]);

    $component->assertSee(
        $gallery
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create gallery route', function () {
    $this->webActingAs();

    $this->get(route('gallery.create'))
        ->assertOk()
        ->assertSeeLivewire(GalleryCreate::class);
});

it('create a gallery', function () {
    $this->webActingAs();

    $gallery = Gallery::factory()->make();
    $page = Page::first();

    $language = Language::query()->first();

    livewire(GalleryCreate::class)
        ->set('gallery.language_id', $language->id)
        ->set('gallery.page_id', $page->id)
        ->set('gallery.title', $gallery->title)
        ->set('gallery.slug', $gallery->slug)
        ->set('gallery.description', $gallery->description)
        ->set('gallery.status', $gallery->status)
        ->set('gallery.sort', $gallery->sort)
        ->call('create')
        ->assertRedirect(route('gallery.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('galleries', [
        'language_id' => $language->id,
        'page_id' => $page->id,
        'title' => $gallery->title,
        'slug' => $gallery->slug,
        'description' => $gallery->description,
        'status' => $gallery->status,
    ]);
});

it('shows gallery', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $gallery = Gallery::factory()->create();

    $this->get(route('gallery.show', ['model' => $gallery->id]))
        ->assertOk()
        ->assertSeeLivewire(GalleryShow::class)
        ->assertSee([
            'Title',
            'Description',
        ])
        ->assertSee([
            $gallery->title,
            $gallery->description,
        ]);
});

it('load gallery route', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $gallery = Gallery::factory()->create();

    $this->get(route('gallery.edit', ['model' => $gallery->id]))
        ->assertOk()
        ->assertSeeLivewire(GalleryEdit::class)
        ->assertSee([
            'Title',
            'Description',
        ])
        ->assertSee([
            $gallery->title,
            $gallery->description,
        ]);
});

it('update gallery', function () {
    $this->webActingAs();

    $page = Page::first();

    $gallery = Gallery::factory()->create([
        'title' => 'Galleries Title',
        'page_id' => $page->id,
    ]);

    livewire(GalleryEdit::class, ['model' => $gallery->id])
        ->set('gallery.title', 'Galleries Title Edited')
        ->set('gallery.page_id', $page->id)
        ->call('update')
        ->assertRedirect(route('gallery.list'))
        ->assertSessionHas('message');

    $gallery->refresh();

    expect($gallery)
        ->page_id->toBe($page->id)
        ->title->toBe('Galleries Title Edited');
});
