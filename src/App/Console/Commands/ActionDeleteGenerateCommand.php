<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class ActionDeleteGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:delete-action
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Delete Action file from table definiton';

    protected string $classTypeNamespace = 'Actions';

    protected string $classType = 'DeleteAction';

    protected string $stubFilename = 'DeleteAction.stub';

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
