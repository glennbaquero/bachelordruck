<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class LivewireCreateGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:livewire-create
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Livewire Create file from table definiton';

    protected string $classTypeNamespace = 'Create';

    protected string $classType = 'Create';

    protected string $stubFilename = 'LivewireCreate.stub';

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
