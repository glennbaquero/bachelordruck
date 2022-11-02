<?php

namespace Domain\Galleries\Models;

use App\Enums\StatusEnum;
use Database\Factories\GalleryFactory;
use Domain\Galleries\QueryBuilders\GalleryQueryBuilder;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $guarded = [];

    protected $cast = [
        'language_id' => 'integer',
        'page_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'status' => StatusEnum::class,
        'sort' => 'integer',
        'slug' => 'string',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('title', 'LIKE', '%'.$searchTerm.'%');
    }

    protected static function newFactory()
    {
        return GalleryFactory::new();
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
    }

    public function newEloquentBuilder($query): GalleryQueryBuilder
    {
        return new GalleryQueryBuilder($query);
    }
}
