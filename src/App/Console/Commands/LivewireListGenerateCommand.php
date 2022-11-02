<?php

namespace App\Console\Commands;

use App\Contracts\AbstractGeneratorCommand;
use Illuminate\Support\Str;

class LivewireListGenerateCommand extends AbstractGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:livewire-list
    {--domain=}
    {--table=}
    {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Livewire List file from table definiton';

    protected string $classTypeNamespace = 'Lists';

    protected string $classType = 'List';

    protected string $stubFilename = 'LivewireList.stub';

    protected string $targetStructure = 'livewire';

    protected function replaceGenerate(string $buildClass): string
    {
        $replace = [
            '{{ modelLowercase }}' => (string) Str::of($this->table)->singular(),
            '{{ model }}' => (string) Str::of($this->table)->ucfirst()->singular(),
            '{{ domain }}' => $this->domain,
            '{{ columnsDefinition }}' => $this->getColumnsDefinition(),
        ];

        return Str::replace(array_keys($replace), array_values($replace), $buildClass);
    }

    private function getColumnCode(\StdClass $column): string
    {
        $modelLowercase = (string) Str::of($this->table)->singular();
        $type = Str::of($column->Type)->lower();
        if ($type->startsWith(['tinyint(1)'])) {
            return "Column::boolean(field: '".$column->Field."', token: '".$modelLowercase."')->sortable(),".PHP_EOL;
        }

        return "Column::text(field: '".$column->Field."', token: '".$modelLowercase."')->sortable(),".PHP_EOL;
    }

    private function getColumnsDefinition(): string
    {
        $phpCode = '';
        foreach ($this->loadFields() as $column) {
            if (in_array($column->Field, ['id', 'created_at', 'updated_at'], true)) { // skip
                continue;
            }
            $phpCode .= $this->getColumnCode($column);
        }

        return $phpCode;
    }
}
