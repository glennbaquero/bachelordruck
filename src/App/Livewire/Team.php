<?php

namespace App\Livewire;

use Domain\Teams\Models\Team as TeamModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use function view;

class Team extends Component
{
    public TeamModel $team;

    public function mount(int $id): void
    {
        $this->team = TeamModel::findOrFail($id);
    }

    public function render(): View
    {
        return view('livewire.team');
    }
}
