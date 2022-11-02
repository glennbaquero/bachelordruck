<?php

namespace Domain\Containers\Jobs;

use Domain\Containers\Actions\ContainerChangeStatusAction;
use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Models\Container;
use Domain\Containers\Tasks\CopyContainerMediaTask;
use Domain\Containers\Tasks\TranslateContainerTask;
use Domain\Exceptions\UnableToCopyContainerMedia;
use Domain\Exceptions\UnableToTranslateContainerText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CopyContainerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected Container $container,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $tasks = [
                CopyContainerMediaTask::class,
                TranslateContainerTask::class,
            ];

            /** @var Container $container */
            app(Pipeline::class)
                ->send($this->container)
                ->through($tasks)
                ->then(function (Container $container) {
                    app(ContainerChangeStatusAction::class)($container, ContainerStatusEnum::READY);
                });
        } catch (UnableToCopyContainerMedia $exception) {
            $exception->setContainer($this->container);
            report($exception);
        } catch (UnableToTranslateContainerText $exception) {
            $exception->setContainer($this->container);
            report($exception);
        }
    }
}
