<?php

namespace Tests\Feature\Domain\News;

use App\Enums\StatusEnum;
use Domain\News\Actions\NewsCreateAction;
use Domain\News\Actions\NewsDeleteAction;
use Domain\News\Actions\NewsUpdateAction;
use Domain\News\DataTransferObjects\NewsData;
use Domain\News\FieldEnums\NewsFieldEnum;
use Domain\News\Models\News;
use Domain\News\Rules\NewsRules;
use Illuminate\Support\Str;

test('create news data from model', function () {
    $news = News::factory()->make();

    $data = NewsData::fromModel($news);

    expect($data)
        ->title->toEqual($news->title)
        ->slug->toEqual(Str::slug($news->title))
        ->description->toEqual($news->description)
        ->video_url->toEqual($news->video_url)
        ->news_date->toEqual($news->news_date)
        ->status->toEqual(StatusEnum::ACTIVE);
});

test('news create action', function () {
    $news = News::factory()->make();

    $data = NewsData::fromModel($news);

    app(NewsCreateAction::class)($data);

    $this->assertDatabaseHas('news', $data->toArray());
});

test('news update action', function () {
    $news = News::factory()->make();

    $data = NewsData::fromModel($news);

    $news = app(NewsCreateAction::class)($data);

    $data = NewsData::fromModel($news);

    $newFieldValue = 'Test Title';

    $data->title = $newFieldValue;

    app(NewsUpdateAction::class)($news, $data);

    $news->refresh();

    expect($news)
        ->title->toEqual($newFieldValue);
});

test('news delete action', function () {
    $news = News::factory()->make();

    $data = NewsData::fromModel($news);

    $news = app(NewsCreateAction::class)($data);

    app(NewsDeleteAction::class)($news);

    $this->assertModelMissing($news);
});

test('news field enum labels', function () {
    app()->setLocale('en');

    expect(NewsFieldEnum::labels())->toBe([
        'language_id' => 'Language',
        'description' => 'Description',
        'slug' => 'Slug',
        'video_url' => 'Video Url',
        'title' => 'Title',
        'status' => 'Status',
        'news_date' => 'News Date',
        'image' => 'newsFields.image', // TODO: Translate
        'images' => 'newsFields.images',
        'pdf' => 'newsFields.pdf',
    ]);
});

test('news rules key is prepended', function () {
    expect(array_keys(NewsRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('news.');
});
