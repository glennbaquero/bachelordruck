<?php

namespace App\Livewire\Traits;

trait WithModals
{
    public ?int   $currentId = null;

    public bool $showModal = false;

    public string $parentComponent = '';

    public string $modalComponentName = '';

    public string $modalComponentTitle = '';

    public ?string $childModelId = null;

    public function getListeners()
    {
        return $this->listeners + ['showModal', 'close'];
    }

    public function showModal(string $modalComponentName, string $modalComponentTitle, ?string $childModelId = null)
    {
        $this->modalComponentName = $modalComponentName;
        $this->modalComponentTitle = $modalComponentTitle;
        $this->childModelId = $childModelId;

        $this->showModal = true;
    }

    public function renderModalFromQuery()
    {
        if ($this->modalComponentName) {
            $this->showModal($this->modalComponentName, $this->modalComponentTitle, $this->childModelId);
        }
    }

    public function close(): void
    {
        $this->modalComponentName = '';
        $this->modalComponentTitle = '';
        $this->childModelId = null;
        $this->showModal = false;
    }
}
