<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;

trait WithParentModel
{
    public int|string $parentModelId;

    public string $parentModelLocalKey;

    public Model $parentModel;
}
