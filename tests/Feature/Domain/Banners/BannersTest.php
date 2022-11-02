<?php

namespace Tests\Feature\Domain\Banners;

use App\Enums\StatusEnum;
use Domain\Banners\Actions\BannerCreateAction;
use Domain\Banners\Actions\BannerDeleteAction;
use Domain\Banners\Actions\BannerUpdateAction;
use Domain\Banners\DataTransferObjects\BannerData;
use Domain\Banners\FieldEnums\BannerFieldEnum;
use Domain\Banners\Models\Banner;
use Domain\Banners\Rules\BannerRules;

test('create banner data from model', function () {
    $banner = Banner::factory()->make();

    $data = BannerData::fromModel($banner);

    expect($data)
        ->title->toEqual($banner->title)
        ->language_id->toEqual($banner->language_id)
        ->transmission->toEqual(true)
        ->description->toEqual($banner->description)
        ->url->toEqual($banner->url)
        ->link_text->toEqual($banner->link_text)
        ->status->toEqual(StatusEnum::ACTIVE);
});

test('banner create action', function () {
    $banner = Banner::factory()->make();

    $data = BannerData::fromModel($banner);

    $createdBanner = app(BannerCreateAction::class)($data);

    $data->id = $createdBanner->id;

    $this->assertDatabaseHas('banners', $data->toArray());
});

test('banner update action', function () {
    $banner = Banner::factory()->create();

    $data = BannerData::fromModel($banner);

    $newFieldValue = 'New Title';

    $data->title = $newFieldValue;

    app(BannerUpdateAction::class)($banner, $data);

    $banner->refresh();

    expect($banner)
        ->title->toEqual($newFieldValue);
});

test('banner delete action', function () {
    $banner = Banner::factory()->create();

    app(BannerDeleteAction::class)($banner);

    $this->assertModelMissing($banner);
});

test('banner field enum labels', function () {
    app()->setLocale('en');

    expect(BannerFieldEnum::labels())->toBe([
        'id' => 'Id',
        'page_id' => 'Page',
        'language_id' => 'Language',
        'transmission' => 'Transmission',
        'title' => 'Title',
        'description' => 'Description',
        'url' => 'Url',
        'link_text' => 'Link text',
        'sort' => 'Sort',
        'status' => 'Status',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'image' => 'Image',
    ]);
});

test('banner rules key is prepended', function () {
    expect(array_keys(BannerRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('banner.');
});
