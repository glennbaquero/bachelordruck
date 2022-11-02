<?php

namespace Tests\Feature\Domain\Galleries;

use App\Enums\StatusEnum;
use Domain\Galleries\Actions\GalleryCreateAction;
use Domain\Galleries\Actions\GalleryDeleteAction;
use Domain\Galleries\Actions\GalleryUpdateAction;
use Domain\Galleries\DataTransferObjects\GalleryData;
use Domain\Galleries\FieldEnums\GalleryFieldEnum;
use Domain\Galleries\Models\Gallery;
use Domain\Galleries\Rules\GalleryRules;
use Domain\Pages\Models\Page;
use Illuminate\Support\Str;

test('create gallery data from model', function () {
    $gallery = Gallery::factory()->make();

    $page = Page::first();
    $gallery->page_id = $page->id;

    $data = GalleryData::fromModel($gallery);

    expect($data)
        ->page_id->toEqual($gallery->page_id)
        ->page_id->not()->toBeNull()
        ->title->toEqual($gallery->title)
        ->slug->toEqual(Str::slug($gallery->title))
        ->description->toEqual($gallery->description)
        ->status->toEqual(StatusEnum::ACTIVE);
});

test('gallery create action', function () {
    $gallery = Gallery::factory()->make();

    $page = Page::first();
    $gallery->page_id = $page->id;

    $data = GalleryData::fromModel($gallery);

    app(GalleryCreateAction::class)($data);

    $this->assertDatabaseHas('galleries', $data->toArray());
});

test('gallery update action', function () {
    $gallery = Gallery::factory()->make();

    $data = GalleryData::fromModel($gallery);

    $gallery = app(GalleryCreateAction::class)($data);

    $data = GalleryData::fromModel($gallery);

    $page = Page::first();

    $newFieldValue = 'Test Title';

    $data->title = $newFieldValue;
    $data->page_id = $page->id;

    app(GalleryUpdateAction::class)($gallery, $data);

    $gallery->refresh();

    expect($gallery)
        ->page_id->toEqual($page->id)
        ->title->toEqual($newFieldValue);
});

test('gallery delete action', function () {
    $gallery = Gallery::factory()->make();

    $data = GalleryData::fromModel($gallery);

    $gallery = app(GalleryCreateAction::class)($data);

    app(GalleryDeleteAction::class)($gallery);

    $this->assertModelMissing($gallery);
});

test('gallery field enum labels', function () {
    app()->setLocale('en');

    expect(GalleryFieldEnum::labels())->toBe([
        'language_id' => 'Language',
        'page_id' => 'Page',
        'title' => 'Title',
        'description' => 'Description',
        'status' => 'Status',
        'sort' => 'Sort',
        'image' => 'galleryFields.image',
        'images' => 'galleryFields.images',
        'slug' => 'Slug',
        'pdf' => 'galleryFields.pdf',
    ]);
});

test('gallery rules key is prepended', function () {
    expect(array_keys(GalleryRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('gallery.');
});
