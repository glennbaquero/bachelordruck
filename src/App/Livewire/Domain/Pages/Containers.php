<?php

namespace App\Livewire\Domain\Pages;

use Domain\Containers\Actions\ContainerCreateAction;
use Domain\Containers\Actions\ContainerDeleteAction;
use Domain\Containers\Actions\ContainerSortAction;
use Domain\Containers\Actions\ContainerUpdateAction;
use Domain\Containers\Collections\ContainerCollection;
use Domain\Containers\DataTransferObjects\ContainerData;
use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Models\Container;
use Domain\Containers\Rules\ContainersRules;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class Containers extends Component
{
    use WithMedia;

    public string $name = 'page';

    public PageLanguage $pageLanguage;

    public bool $showModalContainerConfirmation = false;

    public ?int $currentSelectedIndex = null;

    public string $mediaCollectionName = 'images';

    public $mediaComponentNames = ['images'];

    public $images;

    public ContainerCollection|Collection $containers;

    public ?Container $container;

    public ?int $containerIdForDeletion = null;

    public function mount(PageLanguage $pageLanguage): void
    {
        $this->pageLanguage = $pageLanguage;

        $this->containers = $this->pageLanguage->containers;

        $this->resetContainer();
    }

    public function render(): View
    {
        $this->container->loadMissing('media');
        $this->containers->loadMissing('media');

        return view('livewire.pages.containers');
    }

    public function rules(): array
    {
        $rules = ContainersRules::getRules();

        if (! $this->container->type) {
            return $rules;
        }

        $combinedRules = [
            ...$rules,
            ...$this->container->type->getRules(),
        ];

        if ($this->shouldRemoveImageValidationRule()) {
            unset($combinedRules['container.image']);
        }

        return $combinedRules;
    }

    /**
     * Check whether the container being updated has an image and should remove image validation rule.
     *
     * @return bool
     */
    protected function shouldRemoveImageValidationRule(): bool
    {
        if (! $this->container->id) {
            return false;
        }

        if (! $this->container->type->hasImage()) {
            return false;
        }

        $media = $this->container->getFirstMedia($this->mediaCollectionName);

        return $media !== null;
    }

    public function insertNewContainer(string $containerTypeName): void
    {
        $containerType = ContainerTypeEnum::from($containerTypeName);

        $container = $containerType->getDefaultContainer($this->containers, $this->pageLanguage->id);

        $this->containers->push($container);

        $this->container = $container;
    }

    protected function syncContainerMedia(): void
    {
        if ($this->container->type->hasImage() && ! empty($this->images)) {
            $this->container->syncFromMediaLibraryRequest($this->images)->toMediaCollection($this->mediaCollectionName);
        }
    }

    /**
     * Gets the index of the container from the containers collection.
     *
     * @return int
     */
    protected function getContainerIndex(): int
    {
        return $this->containers->search(function ($container) {
            return $container->id === $this->container->id;
        });
    }

    /**
     * It updates the preview of the container without retreiving data from DB.
     * This updates the container in the containers collection.
     *
     * @return void
     */
    protected function updateContainers(): void
    {
        if ($this->container->wasRecentlyCreated) {
            $this->containers->pop();

            $this->containers->push($this->container->refresh());
        } else {
            $this->containers[$this->getContainerIndex()] = $this->container->refresh();
        }
    }

    /**
     * Save the container.
     *
     * @return void
     */
    public function save(): void
    {
        $this->fillImageForValidation();

        $this->validate();

        $containerData = ContainerData::fromModel($this->container);

        if (! $this->container->id) {
            $this->container = app(ContainerCreateAction::class)($containerData);
        } else {
            $this->container = app(ContainerUpdateAction::class)($this->container, $containerData);
        }

        $this->syncContainerMedia();

        $this->updateContainers();

        $this->resetContainer();
    }

    protected function fillImageForValidation(): void
    {
        if ($this->container->type->hasImage() && ! empty($this->images)) {
            $this->container->image = $this->images;
        }
    }

    public function updateContainerOrder(array $sortingData): void
    {
        app(ContainerSortAction::class)(
            $this
            ->containers
            ->sortContainers($sortingData)
            ->sortedDataToUpdate()
        );
    }

    public function hideDeleteContainerConfirmation(): void
    {
        $this->showModalContainerConfirmation = false;
    }

    public function deleteContainer(): void
    {
        if ($this->containerIdForDeletion) {
            $containerToDelete = $this->containers->find($this->containerIdForDeletion);

            app(ContainerDeleteAction::class)($containerToDelete);

            $this->containers->deleteContainer($containerToDelete);

            $this->hideDeleteContainerConfirmation();

            $this->resetContainer();
        }
    }

    public function editContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * Cancel adding or editing of container.
     *
     * @return void
     */
    public function cancel(): void
    {
        if (! $this->container->id) {
            $this->containers->pop();
        }

        $this->resetContainer();
    }

    public function isEditing(Container $container): bool
    {
        return ! $container->id || (isset($this->container) && $container->id === $this->container->id);
    }

    /**
     * Check if there is an active container being made, unsaved container.
     *
     * @return bool
     */
    public function getHasNewContainerProperty(): bool
    {
        return ! $this->container->id && $this->container->type;
    }

    /**
     * Check if there is an active container being made, unsaved container.
     *
     * @return bool
     */
    public function getHasActiveContainerProperty(): bool
    {
        return $this->container->id || $this->hasNewContainer;
    }

    /**
     * It clears the uploaded image.
     * The x-input.upload components needs to be refactored.
     *
     * @return void
     */
    public function clearAvatar(): void
    {
        $this->container->clearMediaCollection($this->mediaCollectionName);
    }

    protected function resetContainer(): void
    {
        $this->container = new Container();
    }
}
