<?php

namespace Tests\Feature\Domain\Containers;

use Database\Seeders\PageSeeders\MainNavigation\Home;
use Domain\Containers\Actions\ContainerCopyAction;
use Domain\Containers\Actions\ContainerCopyMediaFromSourceAction;
use Domain\Containers\Actions\ContainerTranslateTextAction;
use Domain\Containers\Collections\ContainerCollection;
use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Jobs\CopyContainersJob;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;
use Support\Translator\Services\DeeplTranslatorService;

beforeEach(function () {
    app(Home::class)->seed();
});

it('will copy containers into the database', function () {
    $sourcePageLanguage = PageLanguage::where('name', 'Startseite')->first();

    createContainerData($sourcePageLanguage);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $sourcePageLanguage->id)
        ->get();

    $destinationPageLanguage = PageLanguage::where('name', 'Home')->first();

    app(ContainerCopyAction::class)($destinationPageLanguage, $containers->pluck('id')->all());

    $containers->each(function ($container) use ($destinationPageLanguage) {
        $attributes = [
            'sort',
            'content',
            'image_alignment',
            'title',
            'type',
            'options',
            'url',
        ];

        $copiedContainer = Container::query()
            ->where('source_container_id', $container->id)
            ->first();

        foreach ($attributes as $attribute) {
            expect($copiedContainer->{$attribute})->toEqual($container->{$attribute});
        }

        expect($copiedContainer)
            ->status->toEqual(ContainerStatusEnum::COPYING)
            ->pages_language_id->toBe($destinationPageLanguage->id)
            ->created_at->not->toBeNull()
            ->updated_at->not->toBeNull();
    });
});

it('will copy media from source container', function () {
    $sourcePageLanguage = PageLanguage::where('name', 'Startseite')->first();
    createContainerData($sourcePageLanguage);

    /** @var Container $container */
    $container = Container::query()
        ->where('pages_language_id', $sourcePageLanguage->id)
        ->first();

    attachMediaToModel($container);

    $destinationPageLanguage = PageLanguage::where('name', 'Home')->first();

    app(ContainerCopyAction::class)($destinationPageLanguage, [$container->id]);

    $copiedContainer = Container::query()
        ->where('pages_language_id', $destinationPageLanguage->id)
        ->first();

    app(ContainerCopyMediaFromSourceAction::class)($copiedContainer);

    expect($copiedContainer->media)->toHaveCount(1);
    expect($copiedContainer->media->first())
        ->name->toBe('space')
        ->file_name->toBe('space.png');
});

it('will translate copied container', function () {
    $pageLanguage = PageLanguage::query()->where('name', 'Startseite')->first();

    $sourceContainer = Container::factory()->create([
        'sort' => 1,
        'pages_language_id' => $pageLanguage->id,
        'title' => 'Hallo Welt!',
        'content' => 'Inhalt Hallo Welt!',
        'type' => ContainerTypeEnum::HEADLINE_TEXT->value,
    ]);

    $destinationPageLanguage = PageLanguage::where('name', 'Home')->first();

    app(ContainerCopyAction::class)($destinationPageLanguage, [$sourceContainer->id]);

    $copiedContainer = Container::query()
        ->where('pages_language_id', $destinationPageLanguage->id)
        ->first();

    $this->mockTranslator([
        'Hello World!',
        'Content Hello World!',
    ]);

    app(ContainerTranslateTextAction::class)($copiedContainer);

    $copiedContainer->refresh();

    expect($copiedContainer)
        ->title->toBe('Hello World!')
        ->content->toBe('Content Hello World!');
});

it('will copy media and translate copied container', function () {
    $pageLanguage = PageLanguage::query()->where('name', 'Startseite')->first();

    $sourceContainer = Container::factory()->create([
        'sort' => 1,
        'pages_language_id' => $pageLanguage->id,
        'title' => 'Hallo Welt!',
        'content' => 'Inhalt Hallo Welt!',
        'type' => ContainerTypeEnum::HEADLINE_TEXT_IMAGE->value,
    ]);

    attachMediaToModel($sourceContainer);

    $destinationPageLanguage = PageLanguage::where('name', 'Home')->first();

    app(ContainerCopyAction::class)($destinationPageLanguage, [$sourceContainer->id]);

    config()->set('translator.service_class', DeeplTranslatorService::class);

    $this->mockTranslator([
        'Hello World!',
        'Content Hello World!',
    ]);

    CopyContainersJob::dispatch([$sourceContainer->id]);

    $copiedContainer = Container::query()
        ->where('source_container_id', $sourceContainer->id)
        ->first();

    // Media is now copied
    expect($copiedContainer->media)->toHaveCount(1);
    expect($copiedContainer->media->first())
        ->name->toBe('space')
        ->file_name->toBe('space.png');

    // Text is now translated
    expect($copiedContainer)
        ->title->toBe('Hello World!')
        ->content->toBe('Content Hello World!')
        ->status->toEqual(ContainerStatusEnum::READY);
});
