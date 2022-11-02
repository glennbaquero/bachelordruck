<?php

namespace Domain\Pages\Models;

use Database\Factories\PageLanguageFactory;
use Domain\Containers\Models\Container;
use Domain\Pages\Collections\PageLanguageCollection;
use Domain\Pages\Enums\TargetTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageLanguage extends Model
{
    use HasFactory;

    protected $table = 'page_languages';
//    protected $with = ['containers', 'page'];

    protected $fillable = [
        'page_id',
        'language_id',
        'url',
        'target_type',
        'name',
        'title',
        'layout_id',
        'description',
        'active',
        'visible',
    ];

    protected $casts = [
        'active' => 'boolean',
        'visible' => 'boolean',
        'page_id' => 'integer',
        'language_id' => 'integer',
        'layout_id' => 'integer',
        'target_type' => TargetTypeEnum::class,
    ];

    public static function boot()
    {
        parent::boot();

        $cacheKeys = [
            'page_language_main_navigation',
            'page_language_footer_navigation',
        ];

        static::saved(function ($item) use ($cacheKeys) {
            foreach ($cacheKeys as $key) {
                cache()->forget($key);
            }
        });

        static::deleted(function ($item) use ($cacheKeys) {
            foreach ($cacheKeys as $key) {
                cache()->forget($key);
            }
        });
    }

    public function newCollection(array $models = []): PageLanguageCollection
    {
        return new PageLanguageCollection($models);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function layout(): BelongsTo
    {
        return $this->belongsTo(Layout::class);
    }

    public function containers()
    {
        return $this->hasMany(Container::class, 'pages_language_id', 'id')->orderBy('sort');
    }

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('name', 'LIKE', '%'.$searchTerm.'%');
    }

    public function getNameWithLanguageCode(): string
    {
        return $this->name.' ('.strtoupper($this->language->languageCode).')';
    }

    protected static function newFactory()
    {
        return PageLanguageFactory::new();
    }

    public function languageUrl(): Attribute
    {
        return Attribute::get(fn () => '/'.$this->language->languageCode.$this->url);
    }
}
