<?php

namespace App\Livewire\Traits;

use Exception;

trait WithCreateAction
{
    public bool   $useModal = false;

    public ?string $formTitle = null;

    public string $createButtonTitle = '';

    public string $createRoute = '';

    protected $createModalCallback;

    /**
     * @throws Exception
     */
    public function createAction()
    {
        if (! $this->useModal && $this->createRoute === '') {
            throw new Exception('The create route property is not set.');
        }

        if (! $this->useModal) {
            return redirect()->to($this->createRoute);
        }

        if (is_callable($this->createModalCallback())) {
            return app()->call($this->createModalCallback());
        }

        throw new Exception('Create modal callback is not callable');
    }
}
