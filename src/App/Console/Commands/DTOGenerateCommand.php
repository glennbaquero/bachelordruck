<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class DTOGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dto
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Data Transfer Object file from table definiton';

    protected string $classTypeNamespace = 'DataTransferObject';

    protected string $classType = 'Data';

    protected string $stubFilename = 'DataTransferObject.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ fieldDefinition }}' => $this->getFieldDefinition(),
            '{{ fieldMapping }}' => $this->getFieldMapping(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function isNullable(\StdClass $column): bool
    {
        if ($column->Field === 'id') {
            return true;
        }
        if ($column->Null === 'YES') {
            return true;
        }

        return false;
    }

    private function getFieldMapping(): string
    {
        $modelName = '$'.Str::of($this->table)->singular();

        $phpCode = '';
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= $column->Field.':'.$modelName.'->'.$column->Field.($this->isNullable($column) ? ' ?? null' : '').',';
            $phpCode .= PHP_EOL;
        }

        return $phpCode;
    }

    private function getType(\StdClass $column): string
    {
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith(['tinyint(1)'])) {
            return 'bool';
        }
        if ($type->startsWith(['tinyint(', 'mediumint(', 'bigint(', 'smallint(', 'int('])) {
            return 'int';
        }

        return 'string';
    }

    private function getFieldDefinition(): string
    {
        $phpCode = '';
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= 'public '.($this->isNullable($column) ? '?' : '').$this->getType($column).' $'.$column->Field.';';

            $phpCode .= PHP_EOL;
        }

        return $phpCode;
    }
}
