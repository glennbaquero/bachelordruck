<?php

namespace App\Console\Commands;

use Domain\Orders\Actions\BasketPositionsClearAction;
use Illuminate\Console\Command;

class BasketPostionsClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basket_positions:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear basket positions that are created on "n" hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(BasketPositionsClearAction::class)();
    }
}
