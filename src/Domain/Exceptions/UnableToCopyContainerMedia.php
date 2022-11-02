<?php

namespace Domain\Exceptions;

use Domain\Containers\Models\Container;
use Exception;
use Illuminate\Support\Facades\Log;

class UnableToCopyContainerMedia extends Exception
{
    protected Container $container;

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::debug('Unable to copy media of container: '.$this->container->id);
    }

    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }
}
