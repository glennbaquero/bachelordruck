<?php

namespace Domain\Headlines\Models;

use Domain\Containers\Models\Container;
use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $fillable = [
        'container_id',
        'title',
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
