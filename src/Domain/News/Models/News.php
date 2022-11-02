<?php

namespace Domain\News\Models;

use App\Enums\StatusEnum;
use Database\Factories\NewsFactory;
use Domain\News\QueryBuilders\NewsQueryBuilder;
use Domain\Pages\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class News extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $table = 'news';

    protected $guarded = [];

    protected $casts = [
        'language_id' => 'integer',
        'slug' => 'string',
        'title' => 'string',
        'description' => 'string',
        'video_url' => 'string',
        'news_date' => 'string',
        'status' => StatusEnum::class,
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('title', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('video_url', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('slug', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
    }

    protected static function newFactory()
    {
        return NewsFactory::new();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->withResponsiveImages();

        $this
            ->addMediaCollection('images')
            ->withResponsiveImages();

        $this
            ->addMediaCollection('pdf')
            ->withResponsiveImages();
    }

    public function newEloquentBuilder($query): NewsQueryBuilder
    {
        return new NewsQueryBuilder($query);
    }
}
