<?php

namespace Tests\Feature\Domain\Pages;

use Domain\Pages\Actions\PageLanguageCreateAction;
use Domain\Pages\Actions\PageLanguageDeleteAction;
use Domain\Pages\Actions\PageLanguageUpdateAction;
use Domain\Pages\DataTransferObjects\PageData;
use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\FieldEnums\PageFieldEnum;
use Domain\Pages\FieldEnums\PageLanguageFieldEnum;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\Rules\PageLanguageEditRules;
use Domain\Pages\Rules\PageLanguageRules;

test('create page language data from model', function () {
    $pageLanguage = PageLanguage::factory()->make();

    $data = PageLanguageData::fromModel($pageLanguage);

    expect($data)
        ->url->toEqual($pageLanguage->url)
        ->target_type->toEqual($pageLanguage->target_type)
        ->name->toEqual($pageLanguage->name)
        ->title->toEqual($pageLanguage->title)
        ->layout_id->toEqual($pageLanguage->layout_id)
        ->description->toEqual($pageLanguage->description)
        ->active->toEqual($pageLanguage->active);
//        ->visible->toEqual($pageLanguage->visible);
});

test('page language create action', function () {
    $pageLanguage = PageLanguage::factory()->make();

    $data = PageLanguageData::fromModel($pageLanguage);

    $createdPageLanguage = app(PageLanguageCreateAction::class)($data, new PageData(parent_id: null));

    $this->assertDatabaseHas('page_languages', $data->toArray());

    $this->assertDatabaseHas('pages', [
        'id' => $createdPageLanguage->page_id,
    ]);
});

test('page language update action', function () {
    $pageLanguage = PageLanguage::factory()->make();

    $data = PageLanguageData::fromModel($pageLanguage);

    $createdPageLanguage = app(PageLanguageCreateAction::class)($data, new PageData(parent_id: null));

    $newFieldValue = 'Test Edit';

    $data->name = $newFieldValue;

    $updatedPageLanguage = app(PageLanguageUpdateAction::class)($createdPageLanguage, $data);

    expect($updatedPageLanguage)
        ->name->toEqual($newFieldValue);
});

test('page language delete action', function () {
    $pageLanguage = PageLanguage::factory()->make();

    $data = PageLanguageData::fromModel($pageLanguage);

    $createdPageLanguage = app(PageLanguageCreateAction::class)($data, new PageData(parent_id: null));

    app(PageLanguageDeleteAction::class)($createdPageLanguage);

    $this->assertModelMissing($createdPageLanguage);
});

test('page language and page field enum labels', function () {
    app()->setLocale('en');

    expect(PageLanguageFieldEnum::labels())->toBe([
        'id' => 'Id',
        'page_id' => 'Page',
        'language_id' => 'Language',
        'url' => 'Url',
        'target_type' => 'Target Type',
        'name' => 'Name',
        'title' => 'Title',
        'layout_id' => 'Layout',
        'description' => 'Description',
        'active' => 'Active',
        'visible' => 'Visible',
    ]);

    expect(PageFieldEnum::labels())->toBe([
        'id' => 'Id',
        'parent_id' => 'Parent Item',
    ]);
});

test('page language rules key is prepended', function () {
    $rules = array_keys(PageLanguageRules::getRules());

    $pageRule = array_shift($rules);
    expect($pageRule)->toBe('page.parent_id');

    expect($rules)
        ->each(fn ($key) => $key)
        ->toContain('pageLanguage.');
});

test('page edit language rules key is prepended', function () {
    $rules = array_keys(PageLanguageEditRules::getRules());
    expect($rules)->not()->toHaveKeys(['pageLanguage.language_id', 'page.parent_id']);

    expect($rules)
        ->each(fn ($key) => $key)
        ->toContain('pageLanguage.');
});
