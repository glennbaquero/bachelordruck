<?php

namespace Domain\Banners\Models;

use App\Enums\StatusEnum;
use Database\Factories\BannerFactory;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Banner extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'page_id',
        'language_id',
        'title',
        'description',
        'url',
        'link_text',
        'sort',
        'status',
    ];

    protected $casts = [
        'page_id' => 'integer',
        'language_id' => 'integer',
        'transmission' => 'boolean',
        'title' => 'string',
        'description' => 'string',
        'url' => 'string',
        'link_text' => 'string',
        'sort' => 'integer',
        'status' => StatusEnum::class,
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('title', 'LIKE', '%'.$searchTerm.'%')
                     ->orWhere('url', 'LIKE', '%'.$searchTerm.'%')
                     ->orWhere('description', 'LIKE', '%'.$searchTerm.'%')
                     ->orWhere('status', 'LIKE', '%'.$searchTerm.'%')
                     ->orWhere('link_text', 'LIKE', '%'.$searchTerm.'%');
    }

    protected static function newFactory()
    {
        return BannerFactory::new();
    }

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
    }

    public function getImages(): Collection
    {
        return $this->media->map(fn ($media) => $media->getUrl());
    }
}
