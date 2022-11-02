<?php

namespace Domain\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Language extends Model
{
    protected $fillable = ['languageCode', 'title'];

    protected $table = 'cms_languages';

    public function getLabelAttribute(): string
    {
        return $this->title ?? '';
    }

    public function getCodeAttribute(): string
    {
        return Str::upper($this->languageCode);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['label'] = $this->label;

        return $array;
    }
}
