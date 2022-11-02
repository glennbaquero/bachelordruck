<?php

use App\Livewire\Domain\Pages\Create\PageCreate;
use App\Livewire\Domain\Pages\Edit\PageEdit;
use App\Livewire\Domain\Pages\Lists\PagesList;
use Database\Seeders\PageSeeders\MainNavigation\Home;
use Domain\Pages\Models\Layout;
use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads pages list', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $this->get(route('page.list'))
        ->assertOk()
        ->assertSeeText('Create Page')
        ->assertSeeLivewire(PagesList::class);
});

it('displays list of pages', function () {
    $pageLanguages = PageLanguage::all();

    $component = livewire(PagesList::class);

    $component->assertSee(
        $pageLanguages
        ->pluck('name') // Change this to a field/column being displayed
        ->all()
    );
});

it('load create page route', function () {
    $this->webActingAs();

    $this->get(route('page.create'))
        ->assertOk()
        ->assertSeeLivewire(PageCreate::class);
});

it('create a page', function () {
    $this->webActingAs();

    $pageLanguage = PageLanguage::factory()->make();

    $page = Page::query()->first();

    $layout = Layout::query()->first();

    livewire(PageCreate::class)
        ->set('page.parent_id', $page->id)
        ->set('pageLanguage.name', $pageLanguage->name)
        ->set('pageLanguage.title', $pageLanguage->title)
        ->set('pageLanguage.url', $pageLanguage->url)
        ->set('pageLanguage.layout_id', $layout->id)
        ->set('pageLanguage.description', $pageLanguage->description)
        ->set('pageLanguage.active', $pageLanguage->active)
        ->set('pageLanguage.visible', $pageLanguage->visible)
        ->call('create')
        ->assertRedirect(route('page.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('page_languages', [
        'name' => $pageLanguage->name,
        'title' => $pageLanguage->title,
        'url' => $pageLanguage->url,
        'layout_id' => $layout->id,
        'description' => $pageLanguage->description,
        'active' => $pageLanguage->active,
        'visible' => $pageLanguage->visible,
    ]);
});

it('shows page', function () {
    $page = Page::factory()->create();

    $this->get(route('page.show', ['model' => $page->id]))
        ->assertOk()
        ->assertSeeLivewire('domain.pages.show.page-show')
        ->assertSee([
            'FIELD_NAME',
            // Add other fields that are being displayed
        ])
        ->assertSee([
            // Date::format($page->FIELD_NAME_VALUE),
            // $page->FIELD_NAME_VALUE,
        ]);
})->skip('Not being used');

it('load page edit route', function () {
    app(Home::class)->seed();

    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $pageLanguage = PageLanguage::query()
        ->where('name', 'Home')
        ->first();

    $this->get(route('page.edit', ['model' => $pageLanguage->id]))
        ->assertOk()
        ->assertSeeLivewire(PageEdit::class)
        ->assertSee([
            'Name',
            'Title',
        ])
        ->assertSee([
            $pageLanguage->name,
            $pageLanguage->title,
        ]);
});

it('update page', function () {
    app(Home::class)->seed();

    $pageLanguage = PageLanguage::query()
        ->where('name', 'Home')
        ->first();

    livewire(PageEdit::class, ['model' => $pageLanguage->id])
        ->set('pageLanguage.name', 'Home Edited')
        ->call('update')
        ->assertRedirect(route('page.list'))
        ->assertSessionHas('message');

    $pageLanguage->refresh();

    expect($pageLanguage)
        ->name->toBe('Home Edited');
});
