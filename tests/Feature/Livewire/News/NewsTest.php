<?php

use App\Livewire\Domain\News\Create\NewsCreate;
use App\Livewire\Domain\News\Edit\NewsEdit;
use App\Livewire\Domain\News\Lists\NewsList;
use App\Livewire\Domain\News\Show\NewsShow;
use Domain\News\Models\News;
use Domain\Pages\Models\Language;
use function Pest\Livewire\livewire;
use Support\Helpers\UserLanguageSessionHelper;

it('loads news list', function () {
    $this->webActingAs();

    $this->get(route('news.list'))
        ->assertOk()
        ->assertSeeLivewire(NewsList::class);
});

it('displays list of news', function () {
    $news = News::factory()->count(20)->create();

    $component = livewire(NewsList::class);

    expect($component->get('createRoute'))
        ->toBe(route('news.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([]);

    $component->assertSee(
        $news
        ->pluck('title') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create news route', function () {
    $this->webActingAs();

    $this->get(route('news.create'))
        ->assertOk()
        ->assertSeeLivewire(NewsCreate::class);
});

it('create a news', function () {
    $this->webActingAs();

    $news = News::factory()->make();

    $language = Language::query()->first();

    livewire(NewsCreate::class)
        ->set('news.language_id', $language->id)
        ->set('news.title', $news->title)
        ->set('news.slug', $news->slug)
        ->set('news.description', $news->description)
        ->set('news.video_url', $news->video_url)
        ->set('news.news_date', $news->news_date)
        ->set('news.status', $news->status)
        ->call('create')
        ->assertRedirect(route('news.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('news', [
        'language_id' => $language->id,
        'title' => $news->title,
        'slug' => $news->slug,
        'description' => $news->description,
        'video_url' => $news->video_url,
        'news_date' => $news->news_date,
        'status' => $news->status,
    ]);
});

it('shows news', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $news = News::factory()->create();

    $this->get(route('news.show', ['model' => $news->id]))
        ->assertOk()
        ->assertSeeLivewire(NewsShow::class)
        ->assertSee([
            'Title',
            'Description',
        ])
        ->assertSee([
            $news->title,
            $news->description,
        ]);
});

it('load news route', function () {
    $this->webActingAs();

    UserLanguageSessionHelper::set('en');

    $news = News::factory()->create();

    $this->get(route('news.edit', ['model' => $news->id]))
        ->assertOk()
        ->assertSeeLivewire(NewsEdit::class)
        ->assertSee([
            'Title',
            'Description',
        ])
        ->assertSee([
            $news->title,
            $news->description,
        ]);
});

it('update news', function () {
    $this->webActingAs();

    $news = News::factory()->create([
        'title' => 'News Title',
    ]);

    livewire(NewsEdit::class, ['model' => $news->id])
        ->set('news.title', 'News Title Edited')
        ->call('update')
        ->assertRedirect(route('news.list'))
        ->assertSessionHas('message');

    $news->refresh();

    expect($news)
        ->title->toBe('News Title Edited');
});
