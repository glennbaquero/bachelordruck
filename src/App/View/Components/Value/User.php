<?php

namespace App\View\Components\Value;

use Domain\Users\Models\User as UserModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Support\Helpers\NameHelpers;

class User extends Component
{
    public int         $user_id;

    public ?UserModel   $user;

    public bool        $force = false;

    public bool        $short = false;

    public string      $imgUrl = '';

    public string      $initials = '';

    public bool        $readonly = false;

    public bool        $disabled = false;

    private Collection $usersFromCache;

    public function __construct(int $value, bool $force = false, bool $short = false, bool $disabled = false, bool $readonly = false)
    {
        $this->user_id = $value;

        $this->force = $force;
        $this->short = $short;
        $this->readonly = $readonly;
        $this->disabled = $disabled;

        $this->loadTeamsFromCache();
        $this->initUser($value);
    }

    private function initUser(int $user_id): void
    {
        $this->user = $this->usersFromCache->get($user_id);
        $this->initials = $this->user->initials ?? NameHelpers::getInitials($this->user->name);
        $this->imgUrl = $this->user->getFirstMediaUrl('avatars') ?? '';
    }

    private function loadTeamsFromCache(): void
    {
        $this->usersFromCache = Cache::remember('users', 30, function (): Collection {
            return UserModel::with('media')->get(['id', 'name', 'color', 'initials'])->keyBy('id');
        });
    }

    public function render(): View
    {
        return view('components.value.user');
    }
}
