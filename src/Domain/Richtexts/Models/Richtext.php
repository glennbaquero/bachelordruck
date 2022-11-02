<?php

namespace Domain\Richtexts\Models;

use Domain\Containers\Models\Container;
use Illuminate\Database\Eloquent\Model;

class Richtext extends Model
{
    protected $fillable = [
        'container_id',
        'body',
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
