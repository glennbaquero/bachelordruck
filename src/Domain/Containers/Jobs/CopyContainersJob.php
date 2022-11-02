<?php

namespace Domain\Containers\Jobs;

use Domain\Containers\Models\Container;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CopyContainersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected array $sourceContainerIds,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $containers = Container::query()
            ->whereIn('source_container_id', $this->sourceContainerIds)
            ->get();

        $containers->each(function (Container $container) {
            CopyContainerJob::dispatch($container);
        });
    }
}
