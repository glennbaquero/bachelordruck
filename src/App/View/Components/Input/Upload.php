<?php

namespace App\View\Components\Input;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

class Upload extends Component
{
    public string $rules;

    public string $name;

    public ?int $index = null;

    public string $label;

    public Model $model;

    public bool $multiple = false;

    public bool $preview = true;

    public bool $editing = false;

    public bool $customProperty = false;

    public function __construct(
        string $name,
        Model $model,
        string $label,
        string $rules,
        bool $multiple = false,
        int $index = null,
        bool $preview = true,
        bool $editing = false,
        bool $customProperty = false,
    ) {
        $this->name = $name;
        $this->model = $model;
        $this->label = $label;
        $this->index = $index;
        $this->rules = $rules;
        $this->multiple = $multiple;
        $this->preview = $preview;
        $this->editing = $editing;
        $this->customProperty = $customProperty;
    }

    public function render(): View
    {
        return view('components.input.upload');
    }
}
