<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class ActionCreateGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:create-action
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Create Action file from table definiton';

    protected string $classTypeNamespace = 'Actions';

    protected string $classType = 'CreateAction';

    protected string $stubFilename = 'CreateAction.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ fieldMapping }}' => $this->getFieldMapping(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function getFieldMapping(): string
    {
        $dtoName = '$'.Str::of($this->table)->singular().'Data';

        $phpCode = '['.PHP_EOL;
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= "'".$column->Field."' => ".$dtoName.'->'.$column->Field.',';
            $phpCode .= PHP_EOL;
        }
        $phpCode .= ']'.PHP_EOL;

        return $phpCode;
    }
}
