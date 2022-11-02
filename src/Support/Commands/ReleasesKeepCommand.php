<?php

namespace Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ReleasesKeepCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'releases:keep {directory} {--number=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Keep the last N folders in releases directory.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directories = collect(File::directories($this->argument('directory')))->sortBy(function ($dir) {
            return $dir;
        }, SORT_NATURAL)->values();

        $number = abs($this->option('number')) * -1;

        $directories->splice($number);

        foreach ($directories as $directory) {
            $this->info("Deleting directory {$directory}");
            File::deleteDirectory($directory);
        }

        $this->info('Successful!');

        return self::SUCCESS;
    }
}
