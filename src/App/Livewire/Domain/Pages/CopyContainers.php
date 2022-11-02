<?php

namespace App\Livewire\Domain\Pages;

use Domain\Containers\Actions\ContainerCopyAction;
use Domain\Containers\Jobs\CopyContainersJob;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\Services\PageLanguageServices;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class CopyContainers extends Component
{
    use WithMedia;

    public string $name = 'copy_containers';

    /**
     * The selected page languages to copy containers.
     *
     * @var array
     */
    public array $selectedPageLanguages;

    /**
     * Holds the id values of the selected containers to be copied.
     *
     * @var array
     */
    public array $selectedContainerIds = [];

    /**
     * State to show preview of contained in a modal.
     *
     * @var bool
     */
    public bool $showPreviewContainerModal = false;

    /**
     * The current page language to copy containers.
     *
     * @var PageLanguage
     */
    public PageLanguage $currentPageLanguage;

    /**
     * The container in preview.
     *
     * @var Container
     */
    public Container $previewContainer;

    public function mount(PageLanguage $pageLanguage): void
    {
        $this->currentPageLanguage = $pageLanguage;

        $this->loadCurrentPageLanguageContainers();

        $this->selectedPageLanguages = [];
    }

    public function render(): View
    {
        return view('livewire.pages.copy-containers', [
            'pageLanguages' => $this->pageLanguages,
            'sourcePageLanguages' => $this->sourcePageLanguages,
        ]);
    }

    public function rules(): array
    {
        return [];
    }

    public function getPageLanguagesProperty()
    {
        return app(PageLanguageServices::class)->getSelectOptions()->selectOptions();
    }

    public function getSourcePageLanguagesProperty()
    {
        return $this->pageLanguages
            ->whereIn('id', $this->selectedPageLanguages)
            ->each(function ($pageLanguage) {
                $pageLanguage->loadMissing('containers');
            });
    }

    public function previewContainer(int $containerId, bool $useCurrent = false)
    {
        if ($useCurrent) {
            $this->previewContainer = $this->currentPageLanguage->containers->where('id', $containerId)->first();
        } else {
            $containers = $this->sourceContainers();

            $this->previewContainer = $containers->where('id', $containerId)->first();
        }

        $this->showPreviewContainerModal = true;
    }

    public function previewContainerFromCurrentPageLanguage(int $containerId)
    {
        $this->previewContainer($containerId, useCurrent: true);
    }

    public function selectContainer(int $containerId)
    {
        $this->selectedContainerIds[] = $containerId;

        $this->showPreviewContainerModal = false;
    }

    public function unselectContainer(int $containerId)
    {
        unset($this->selectedContainerIds[$containerId]);

        $this->showPreviewContainerModal = false;
    }

    protected function sourceContainers()
    {
        return collect(data_get($this->sourcePageLanguages, '*.containers'))->flatten();
    }

    public function loadCurrentPageLanguageContainers(): void
    {
        $this->currentPageLanguage->load(['language', 'containers']);
    }

    public function copySelectedContainers(): void
    {
        if (empty($this->selectedContainerIds)) {
            $this->addError('no_selected_container', __('Please select at least one container to be copied.'));

            return;
        }

        app(ContainerCopyAction::class)($this->currentPageLanguage, $this->selectedContainerIds);

        $this->loadCurrentPageLanguageContainers();

        CopyContainersJob::dispatch($this->selectedContainerIds);
    }
}
