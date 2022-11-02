<?php

namespace Domain\Products\Models;

use Database\Factories\ProductCoverFoilFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductCoverFoilQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * \Domain\Products\Models\ProductCoverFoil
 *
 * @property int $id
 * @property string $title
 * @property bool $is_preselected
 * @property int $sort
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 *
 * @method static \Database\Factories\ProductCoverFoilFactory factory(...$parameters)
 * @method static Builder|ProductCoverFoil newModelQuery()
 * @method static Builder|ProductCoverFoil newQuery()
 * @method static Builder|ProductCoverFoil search(string $searchTerm)
 * @method static Builder|ProductCoverFoil whereCreatedAt($value)
 * @method static Builder|ProductCoverFoil whereId($value)
 * @method static Builder|ProductCoverFoil whereIsPreselected($value)
 * @method static Builder|ProductCoverFoil whereSort($value)
 * @method static Builder|ProductCoverFoil whereStatus($value)
 * @method static Builder|ProductCoverFoil whereTitle($value)
 * @method static Builder|ProductCoverFoil whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCoverFoil extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'is_preselected',
        'sort',
        'status',
    ];

    protected $casts = [
        'title' => 'string',
        'is_preselected' => 'boolean',
        'sort' => 'integer',
        'status' => StatusEnum::class,
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('title', 'LIKE', '%'.$searchTerm.'%');
//                     ->orWhere('xyz', 'LIKE', '%'.$searchTerm.'%')
    }

    protected static function newFactory()
    {
        return ProductCoverFoilFactory::new();
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

    public static function query(): ProductCoverFoilQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductCoverFoilQueryBuilder
    {
        return new ProductCoverFoilQueryBuilder($query);
    }
}
