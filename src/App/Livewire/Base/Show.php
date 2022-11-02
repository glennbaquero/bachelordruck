<?php

namespace App\Livewire\Base;

use App\Livewire\Traits\WithFormDeleteAction;
use Illuminate\Support\Str;
use Livewire\Component;
use function redirect;
use function view;

abstract class Show extends Component
{
    use WithFormDeleteAction;

    public bool $showBackButton = true;

    abstract public function grids(): array;

    public function children(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.show')
            ->with([
                'grids' => $this->grids(),
                'children' => $this->children(),
                'model' => method_exists($this, 'getModel') ? $this->getModel() : $this->model,
            ]);
    }

    public function getIsGridHasArrayOfFieldsetProperty()
    {
        foreach ($this->grids() as $fieldset) {
            if (is_array($fieldset)) {
                return true;
            }
        }

        return false;
    }

    public function back()
    {
        return redirect(Str::of($this->name)->plural());
    }
}
