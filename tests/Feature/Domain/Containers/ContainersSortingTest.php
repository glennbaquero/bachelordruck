<?php

namespace Tests\Feature\Domain\Containers;

use Domain\Containers\Actions\ContainerSortAction;
use Domain\Containers\Collections\ContainerCollection;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;

test('container sort action as well as container collection', function () {
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();

    createContainerData($pageLanguage);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    $originalContainers = $containers->map(function ($container) {
        return clone $container;
    });

    $sortingData = [
        ['order' => 1, 'value' => '2'], // The third item is moved to the first position
        ['order' => 2, 'value' => '0'], //  The first item is moved to the second position
        ['order' => 3, 'value' => '1'], // The second item is moved to the third position
    ];

    $containers->sortContainers($sortingData);
    $sortedDataToUpdate = $containers->sortedDataToUpdate();

    app(ContainerSortAction::class)($sortedDataToUpdate);

    $originalContainers->each(function ($originalContainer, $index) use ($containers, $sortedDataToUpdate) {
        $newContainerIndex = $containers->search(function ($sortedContainer) use ($originalContainer) {
            return $originalContainer->id === $sortedContainer->id;
        });

        if ($index === 0) {
            // The new position on the first item from the original container is now in the second position
            $newSortPosition = 2;
        } elseif ($index === 1) {
            // The new position on the second item from the original container is now in the third position
            $newSortPosition = 3;
        } else { // Third Item
            // The new position on the third item from the original container is now in the first position
            $newSortPosition = 1;
        }

        // Expect in that the containers are in the proper position
        $newSortPositionIndex = $newSortPosition - 1;
        expect($newContainerIndex)->toBe($newSortPositionIndex);

        // Expect in that the sorted data from ContainerCollection is correct
        expect($sortedDataToUpdate[$newSortPositionIndex]['sort'])->toBe($newSortPosition);

        // Expect that the new sort position is saved in the DB
        $originalContainer->refresh();

        expect($originalContainer)->sort->toBe($newSortPosition);
    });
});

it('will create sorted data to update when the sort value is changed', function () {
    $pageLanguage = PageLanguage::where('name', 'Startseite')->first();
    createContainerData($pageLanguage);

    /** @var ContainerCollection $containers */
    $containers = Container::query()
        ->where('pages_language_id', $pageLanguage->id)
        ->get();

    $originalContainers = $containers->map(function ($container) {
        return clone $container;
    });

    $sortingData = [
        ['order' => 1, 'value' => '2'], // The third item is moved to the first position
        ['order' => 2, 'value' => '1'], // The second item is has no movement
        ['order' => 3, 'value' => '0'], //  The first item is moved to the third position
    ];

    $containers->sortContainers($sortingData);
    $sortedDataToUpdate = $containers->sortedDataToUpdate();

    expect($sortedDataToUpdate)->toHaveCount(2);

    $originalContainers->each(function ($originalContainer, $index) use ($containers, $sortedDataToUpdate) {
        if ($index === 1) {
            return;
        }

        $newContainerIndex = $containers->search(function ($sortedContainer) use ($originalContainer) {
            return $originalContainer->id === $sortedContainer->id;
        });

        if ($index === 0) {
            // The new position on the first item from the original container is now in the second position
            $newSortPosition = 3;
        } else { // Third item
            // The new position on the second item from the original container is now in the third position
            $newSortPosition = 1;
        }

        // Expect in that the containers are in the proper position
        $newSortPositionIndex = $newSortPosition - 1;
        expect($newContainerIndex)->toBe($newSortPositionIndex);

        // Expect in that the sorted data from ContainerCollection is correct
        expect($sortedDataToUpdate[$index === 0 ? 1 : 0]['sort'])->toBe($newSortPosition);
    });
});
