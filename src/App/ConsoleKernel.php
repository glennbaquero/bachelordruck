<?php

namespace App;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;
use Support\Commands\ReleasesKeepCommand;

class ConsoleKernel extends Kernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ReleasesKeepCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('media-library:delete-old-temporary-uploads')->daily();
        $schedule->command('uploads:clear')->daily();
        $schedule->command('basket_positions:clear')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Console/Commands');

        require base_path('routes/console.php');
    }

    private function everyMinutes(int $minutes): string
    {
        return "*/{$minutes} * * * *";
    }
}
