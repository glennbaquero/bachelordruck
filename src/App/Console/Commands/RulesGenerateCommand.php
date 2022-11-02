<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class RulesGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:rules
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Rules file from table definit';

    protected string $classTypeNamespace = 'Rules';

    protected string $classType = 'Rules';

    protected string $stubFilename = 'Rules.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ rules }}' => $this->getRulesCode(),
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function buildRequiredRule(\stdClass $column): string
    {
        if ($column->Null === 'YES') {
            return "'nullable',".PHP_EOL;
        }

        return "'required',".PHP_EOL;
    }

    private function buildTypeRule(\stdClass $column): string
    {
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith(['tinyint(1)'])) {
            return "'boolean',".PHP_EOL;
        }
        if ($type->startsWith(['tinyint(', 'mediumint(', 'bigint(', 'smallint(', 'int('])) {
            return "'integer',".PHP_EOL;
        }
        if ($type->startsWith(['varchar(', 'text', 'smalltext', 'mediumtext', 'bigtext'])) {
            return "'string',".PHP_EOL;
        }

        return '';
    }

    private function buildValidationRule(\stdClass $column): string
    {
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith('enum(')) {
            return "'in:'.implode(',', ".Str::ucfirst($column->Field).'Enum::keys()),'.PHP_EOL;
        }
        if ($type->startsWith('varchar(')) {
            $length = (string) $type->after('(')->before(')');

            return "'max:".$length."',".PHP_EOL;
        }

        return '';
    }

    protected function getRulesCode(): string
    {
        $phpCode = '['.PHP_EOL;
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= "'".$column->Field."' => [".PHP_EOL;
            $phpCode .= $this->buildRequiredRule($column);
            $phpCode .= $this->buildValidationRule($column);
            $phpCode .= $this->buildTypeRule($column);
            $phpCode .= PHP_EOL;
            $phpCode .= '],'.PHP_EOL;
        }
        $phpCode .= '];'.PHP_EOL;

        return $phpCode;
    }
}
