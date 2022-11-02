<?php

namespace Domain\Containers\Collections;

use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Models\Container;
use Illuminate\Database\Eloquent\Collection;

class ContainerCollection extends Collection
{
    protected array $sortedDataToUpdate;

    /**
     * Create a data that will
     *
     * @param  array{order: int, value: string|int }  $sortingData
     * @return void
     */
    protected function setSortedDataToUpdate(array $sortingData): void
    {
        $dataToUpdate = [];

        foreach ($sortingData as $sorting) {
            $newContainerSortValue = $sorting['order'];
            $currentContainerIndex = (int) $sorting['value'];

            if ($this[$currentContainerIndex]->sort !== $newContainerSortValue) {
                $this[$currentContainerIndex]->sort = $newContainerSortValue;

                $dataToUpdate[] = $this[$currentContainerIndex]
                    ->makeHidden(['created_at', 'updated_at'])
                    ->toArray();
            }
        }

        $this->sortedDataToUpdate = $dataToUpdate;
    }

    /**
     * Sort the container base livewire-sortablejs data.
     * It will be triggered by drag and drop event.
     *
     * @param  array{order: int, value: string|int }  $sortingData
     * @return self
     */
    public function sortContainers(array $sortingData): self
    {
        $this->setSortedDataToUpdate($sortingData);

        $this->items = $this->sortBy('sort')->values()->all();

        return $this;
    }

    public function sortedDataToUpdate(): array
    {
        return $this->sortedDataToUpdate;
    }

    /**
     * @param  Container  $containerToDelete
     * @return void
     */
    public function deleteContainer(Container $containerToDelete): void
    {
        $containerToDeleteIndex = $this->search(function ($container) use ($containerToDelete) {
            return $container->id === $containerToDelete->id;
        });

        $this->where('sort', '>', $containerToDelete->sort)
            ->transform(function ($container) {
                $container->sort--;

                return $container;
            });

        $this->splice($containerToDeleteIndex, 1);
    }

    public function isAllReady(): bool
    {
        return $this->where('status', '!==', ContainerStatusEnum::READY)->count() === 0;
    }
}
