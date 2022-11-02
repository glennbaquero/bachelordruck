<?php

namespace Tests\Feature\Domain\Containers;

use Domain\Containers\Actions\ContainerAdjustSortAction;
use Domain\Containers\Actions\ContainerDeleteAction;
use Domain\Containers\Collections\ContainerCollection;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;

it('will delete container from containers correction properly and update sort value', function () {
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();
    createContainerData($pageLanguage);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    $firstContainer = $containers->first();

    $containers->deleteContainer($firstContainer);

    expect($containers)->toHaveCount(2);

    expect($containers[0]->sort)->toBe(1);
    expect($containers[1]->sort)->toBe(2);

    expect($containers->find($firstContainer->id))->toBeNull();

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    $secondContainer = $containers[1];

    $containers->deleteContainer($secondContainer);

    expect($containers)->toHaveCount(2);

    expect($containers[0]->sort)->toBe(1);
    expect($containers[1]->sort)->toBe(2);

    expect($containers->find($secondContainer->id))->toBeNull();
});

it('will update the sort values of containers', function () {
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();
    createContainerData($pageLanguage);

    $container = Container::query()->first();

    app(ContainerAdjustSortAction::class)($container);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    expect($containers->pluck('sort')->all())->toEqual([1, 1, 2]);
});

it('will delete container and update the sort values of affected containers', function () {
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();
    createContainerData($pageLanguage);

    $container = Container::query()->first();

    app(ContainerDeleteAction::class)($container);

    $this->assertModelMissing($container);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    expect($containers->pluck('sort')->all())->toEqual([1, 2]);
});
