<?php

use App\Enums\StatusEnum;
use App\Livewire\Domain\Banners\Create\BannerCreate;
use App\Livewire\Domain\Banners\Edit\BannerEdit;
use App\Livewire\Domain\Banners\Lists\BannersList;
use App\Livewire\Domain\Banners\Show\BannerShow;
use Domain\Banners\Models\Banner;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads banners list', function () {
    $this->webActingAs();

    $this->get(route('banner.list'))
        ->assertOk()
        ->assertSeeLivewire(BannersList::class);
});

it('displays list of banners', function () {
    $banners = Banner::factory()->count(20)->create();
    $component = livewire(BannersList::class);

    expect($component->get('createRoute'))
        ->toBe(route('banner.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([
        'Page',
        'Transmission',
        'Title',
    ]);

    $component->assertSee(
        $banners
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create banner route', function () {
    $this->webActingAs();

    $this->get(route('banner.create'))
        ->assertOk()
        ->assertSeeLivewire(BannerCreate::class);
});

it('create a banner', function () {
    $this->webActingAs();

    $banner = Banner::factory()->make();

    $page = Page::query()->first();
    $language = Language::query()->first();

    livewire(BannerCreate::class)
        ->set('banner.page_id', $page->id)
        ->set('banner.language_id', $language->id)
        ->set('banner.title', $banner->title)
        ->set('banner.description', $banner->description)
        ->set('banner.transmission', true)
        ->set('banner.sort', 1)
        ->set('banner.status', StatusEnum::ACTIVE->value)
        ->call('create')
        ->assertRedirect(route('banner.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('banners', [
        'title' => $banner->title,
        'description' => $banner->description,
        'sort' => 1,
        'status' => 'active',
    ]);
});

it('shows banner', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $banner = Banner::factory()->create();

    $this->get(route('banner.show', ['model' => $banner->id]))
        ->assertOk()
        ->assertSeeLivewire(BannerShow::class)
        ->assertSee([
            'Title',
            'Description',
            'Language',
        ])
        ->assertSee([
            $banner->title,
            $banner->description,
            $banner->language->name,
        ]);
});

it('load banner route', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $banner = Banner::factory()->create();

    $this->get(route('banner.edit', ['model' => $banner->id]))
        ->assertOk()
        ->assertSeeLivewire(BannerEdit::class)
        ->assertSee([
            'Title',
            'Description',
        ])
        ->assertSee([
            $banner->title,
            $banner->description,
        ]);
});

it('update banner', function () {
    $banner = Banner::factory()->create([
        'title' => 'Banner Title',
    ]);

    livewire(BannerEdit::class, ['model' => $banner->id])
        ->set('banner.title', 'Banner New Title')
        ->call('update')
        ->assertRedirect(route('banner.list'))
        ->assertSessionHas('message');

    $banner->refresh();

    expect($banner)
        ->title->toEqual('Banner New Title');
});
