<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class FormGridGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:form-grid
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Form Grid file from table definiton';

    protected string $classTypeNamespace = 'FormGrids';

    protected string $classType = 'FormGrid';

    protected string $stubFilename = 'FormGrid.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ gridDefinition }}' => $this->getGridDefinition(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function getFieldEnum(string $field): string
    {
        return Str::of($this->domain)->singular()->ucfirst().'FieldEnum::'.str::of($field)->upper();
    }

    private function getFieldElement(\StdClass $column): string
    {
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith(['tinyint(1)'])) {
            return 'checkbox('.$this->getFieldEnum($column->Field).')';
        }
        if ($type->startsWith(['tinyint(', 'mediumint(', 'bigint(', 'smallint(', 'int('])) {
            return 'decimal('.$this->getFieldEnum($column->Field).')';
        }

        return 'text('.$this->getFieldEnum($column->Field).')';
    }

    private function getGridDefinition(): string
    {
        $phpCode = '['.PHP_EOL;
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= '$fieldCreator->'.$this->getFieldElement($column).',';
            $phpCode .= PHP_EOL;
        }
        $phpCode .= ']'.PHP_EOL;

        return $phpCode;
    }
}
