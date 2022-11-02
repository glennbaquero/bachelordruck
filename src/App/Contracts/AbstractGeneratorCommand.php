<?php

namespace App\Contracts;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class AbstractGeneratorCommand extends GeneratorCommand
{
    protected string $domain;

    protected string $table;

    protected string $classTypeNamespace; //Actions

    protected string $classType; //z.g. CreateAction

    protected string $stubFilename;

    protected string $targetStructure = 'domain'; // livewire

    public function handle()
    {
        $this->table = $this->option('table') ?? $this->anticipateTable();
        $this->domain = $this->option('domain') ?? $this->anticipateDomain();

        GeneratorCommand::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $relativePath = '/stubs/generate/'.$this->stubFilename;

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.$relativePath;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return base_path('src').'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function anticipatePredefinedValues(string $label, array $values): string
    {
        return $this->anticipate($label.'('.implode(', ', $values).')', function ($input) use ($values): array {
            return $values;
        });
    }

    protected function anticipateDomain(): string
    {
        $path = base_path('src/Domain/');
        $domains = array_map('basename', \File::directories($path));

        return $this->anticipatePredefinedValues('Which Domain?', $domains);
    }

    protected function anticipateTable(): string
    {
        $values = collect(DB::getSchemaBuilder()->getAllTables())->map(function ($row) {
            return current($row);
        })->toArray();

        return $this->anticipatePredefinedValues('Which Table?', $values);
    }

    abstract protected function replaceGenerate(string $buildClass): string;

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        return $this->replaceGenerate(GeneratorCommand::buildClass($name));
    }

    protected function getNameInput(): string
    {
        return Str::of(trim($this->table))->singular()->ucfirst().$this->classType;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace(): string
    {
        if ($this->targetStructure === 'livewire') {
            return 'App\Livewire\Domain\\';
        }

        return 'Domain\\';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\'.$this->domain.'\\'.$this->classTypeNamespace;
    }

    protected function loadFields(): array
    {
        return DB::select('describe '.$this->table);
    }
}
