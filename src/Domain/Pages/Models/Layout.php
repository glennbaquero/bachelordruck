<?php

namespace Domain\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $fillable = ['title', 'token'];

    public function getLabelAttribute(): string
    {
        return $this->title ?? '';
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['label'] = $this->label;

        return $array;
    }
}
