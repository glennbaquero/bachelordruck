<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class FieldEnumGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:field-enum
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Field Enum file from table definiton';

    protected string $classTypeNamespace = 'FieldEnums';

    protected string $classType = 'FieldEnum';

    protected string $stubFilename = 'FieldEnum.stub';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ fieldDefinition }}' => $this->getFieldDefinition(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function getFieldDefinition(): string
    {
        $phpCode = '';
        foreach ($this->loadFields() as $column) {
            $phpCode .= 'case '.str::upper($column->Field)." = '".$column->Field."';";
            $phpCode .= PHP_EOL;
        }

        return $phpCode;
    }
}
