<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class LivewireShowGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:livewire-show
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Livewire Show file from table definiton';

    protected string $classTypeNamespace = 'Show';

    protected string $classType = 'Show';

    protected string $stubFilename = 'LivewireShow.stub';

    protected string $targetStructure = 'livewire';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }
}
