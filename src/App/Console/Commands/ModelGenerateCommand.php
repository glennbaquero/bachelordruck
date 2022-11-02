<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class ModelGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Model file from table definiton';

    protected string $classTypeNamespace = 'Model';

    protected string $classType = '';

    protected string $stubFilename = 'Model.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ fillableCode }}' => $this->getFillableCode(),
            '{{ castsCode }}' => $this->getCastsCode(),
            '{{ labelField }}' => $this->getLabelField(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function getFillableCode(): string
    {
        $phpCode = '['.PHP_EOL;
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= "'".$column->Field."',";
            $phpCode .= PHP_EOL;
        }
        $phpCode .= ']'.PHP_EOL;

        return $phpCode;
    }

    private function getCast(\StdClass $column): string
    {
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith(['tinyint(1)'])) {
            return 'boolean';
        }
        if ($type->startsWith(['tinyint(', 'mediumint(', 'bigint(', 'smallint(', 'int('])) {
            return 'integer';
        }

        return 'string';
    }

    private function getCastsCode(): string
    {
        $phpCode = '['.PHP_EOL;
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= "'".$column->Field."' => '".$this->getCast($column)."',";
            $phpCode .= PHP_EOL;
        }
        $phpCode .= ']'.PHP_EOL;

        return $phpCode;
    }

    private function getLabelField(): string
    {
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['title', 'headline', 'name'], true)) {
                return $column->Field;
            }
        }
        foreach ($this->loadFields() as $column) {
            $type = Str::of($column->Type)->lower();
            if ($type->startsWith(['varchar'])) {
                return $column->Field;
            }
        }

        return 'id'; // fallback
    }
}
