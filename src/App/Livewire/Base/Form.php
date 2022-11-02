<?php

namespace App\Livewire\Base;

use App\Livewire\Traits\WithFormDeleteAction;
use Illuminate\Support\Str;
use Livewire\Component;
use function redirect;
use function view;

abstract class Form extends Component
{
    use WithFormDeleteAction;

    public string $name;

    public string $method = 'update';

    public bool $refresh = false;

    public ?string $listRouteRedirect = null;

    abstract public function grids(): array;

    abstract public function rules(): array;

    public function fieldname(string $field): string
    {
        return $this->name.'.'.$field;
    }

    public function render()
    {
        return view('livewire.form')
            ->with([
                'grids' => $this->grids(),
            ]);
    }

    public function cancel()
    {
        return redirect(Str::of($this->listRouteRedirect ?? $this->name)->plural());
    }
}
