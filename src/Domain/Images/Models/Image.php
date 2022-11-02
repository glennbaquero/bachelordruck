<?php

namespace Domain\Images\Models;

use Domain\Containers\Models\Container;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Image extends Model
{
    use InteractsWithMedia;

    protected $fillable = [
        'description',
        'display_mode',
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
