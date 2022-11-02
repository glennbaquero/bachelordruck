<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;

trait WithAvatar
{
    public $mediaComponentNames = ['avatar'];

    public $avatar;

    public Model $avatarModel;

    public function clearAvatar()
    {
        $this->avatarModel->clearMediaCollection('avatars');
    }
}
