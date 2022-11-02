<?php

namespace Domain\Exceptions;

use Domain\Containers\Models\Container;
use Exception;
use Illuminate\Support\Facades\Log;

class UnableToTranslateContainerText extends Exception
{
    protected Container $container;

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report(): void
    {
        Log::debug('Unable to translate text of container: '.$this->container->id);
    }

    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }
}
