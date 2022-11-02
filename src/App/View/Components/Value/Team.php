<?php

namespace App\View\Components\Value;

use Domain\Teams\Models\Team as TeamModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Support\Helpers\NameHelpers;

class Team extends Component
{
    public int         $team_id;

    public TeamModel   $team;

    public bool        $force = false;

    public bool        $short = false;

    public string      $imgUrl = '';

    public string      $initials = '';

    public bool        $readonly = false;

    public bool        $disabled = false;

    private Collection $teamsFromCache;

    public function __construct(int $value, bool $force = false, bool $short = false, bool $disabled = false, bool $readonly = false)
    {
        $this->team_id = $value;

        $this->force = $force;
        $this->short = $short;
        $this->readonly = $readonly;
        $this->disabled = $disabled;

        $this->loadTeamsFromCache();
        $this->initTeam($value);
        //        dd(TeamModel::with('media')->find(128));
    }

    private function initTeam(int $team_id): void
    {
        $this->team = $this->teamsFromCache->get($team_id);
        $this->initials = $this->team->initials ?? NameHelpers::getInitials($this->team->name);
        $this->imgUrl = $this->team->getFirstMediaUrl('avatars') ?? '';
    }

    private function loadTeamsFromCache(): void
    {
        $this->teamsFromCache = Cache::remember('teams', 30, function (): Collection {
            return TeamModel::with('media')->get(['id', 'name', 'color'])->keyBy('id');
        });
    }

    public function render(): View
    {
        return view('components.value.team');
    }
}
