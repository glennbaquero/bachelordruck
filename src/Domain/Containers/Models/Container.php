<?php

namespace Domain\Containers\Models;

use Database\Factories\ContainerFactory;
use Domain\Containers\Collections\ContainerCollection;
use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property ContainerTypeEnum $type
 */
class Container extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'mysql';

    protected $fillable = [
        'pages_language_id',
        'sort',
        'content',
        'image_alignment',
        'title',
        'type',
        'options',
        'url',
        'source_container_id',
        'status',
    ];

    protected $casts = [
        'pages_language_id' => 'integer',
        'sort' => 'integer',
        'content' => 'string',
        'image_alignment' => 'string',
        'title' => 'string',
        'type' => ContainerTypeEnum::class,
        'options' => 'array',
        'url' => 'string',
        'source_container_id' => 'integer',
        'status' => ContainerStatusEnum::class,
    ];

    public function newCollection(array $models = []): ContainerCollection
    {
        return new ContainerCollection($models);
    }

    protected static function newFactory()
    {
        return ContainerFactory::new();
    }

    public function pageLanguage()
    {
        return $this->belongsTo(PageLanguage::class, 'pages_language_id');
    }

    public function sourceContainer(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function getYoutubeId()
    {
        $urlStr = Str::of($this->url)->after('v=');
        if ($urlStr->length() > 3) {
            return (string) $urlStr;
        }

        return null;
    }
}
