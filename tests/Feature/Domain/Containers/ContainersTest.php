<?php

namespace Tests\Feature\Domain\Containers;

use Domain\Containers\Actions\ContainerCreateAction;
use Domain\Containers\Actions\ContainerUpdateAction;
use Domain\Containers\DataTransferObjects\ContainerData;
use Domain\Containers\Models\Container;
use Domain\Containers\Rules\ContainerHeadlineTextImageRules;
use Domain\Containers\Rules\ContainerHeadlineTextRules;
use Domain\Containers\Rules\ContainerHeadlineTextYoutubeVideoRules;
use Domain\Containers\Rules\ContainerImageRules;
use Domain\Containers\Rules\ContainersRules;
use Domain\Containers\Rules\ContainerYoutubeVideoRules;

test('create container data from model', function () {
    $container = Container::factory()->make();

    $data = ContainerData::fromModel($container);

    expect($data)
        ->sort->toEqual($container->sort)
        ->title->toEqual($container->title)
        ->type->toEqual($container->type)
        ->url->toEqual($container->url)
        ->pages_language_id->toEqual($container->pages_language_id);
});

test('container create action', function () {
    $container = Container::factory()->make();

    $data = ContainerData::fromModel($container);

    app(ContainerCreateAction::class)($data);

    $this->assertDatabaseHas('containers', $data->toArray());
});

test('container update action', function () {
    $container = Container::factory()->create();

    $data = ContainerData::fromModel($container);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ContainerUpdateAction::class)($container, $data);

    $container->refresh();

    expect($container)
        ->title->toEqual($newFieldValue);
});

test('containers rules key is prepended', function () {
    expect(array_keys(ContainersRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('containers.*.');

    expect(array_keys(ContainerHeadlineTextImageRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('container.');

    expect(array_keys(ContainerHeadlineTextRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('container.');

    expect(array_keys(ContainerImageRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('container.');

    expect(array_keys(ContainerYoutubeVideoRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('container.');

    expect(array_keys(ContainerHeadlineTextYoutubeVideoRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('container.');
});
