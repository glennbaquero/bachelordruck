<?php

namespace Domain\Products\Models;

use Database\Factories\ProductBookSpineColorFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductBookSpineColorQueryBuilder;
use Domain\Products\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

/**
 * Domain\Products\Models\ProductBookSpineColor
 *
 * @property int $id
 * @property int $product_id
 * @property string $title
 * @property string $color
 * @property bool $is_preselected
 * @property int $sort
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\ProductBookSpineColorFactory factory(...$parameters)
 * @method static Builder|ProductBookSpineColor newModelQuery()
 * @method static Builder|ProductBookSpineColor newQuery()
 * @method static Builder|ProductBookSpineColor search(string $searchTerm)
 * @method static Builder|ProductBookSpineColor whereColor($value)
 * @method static Builder|ProductBookSpineColor whereCreatedAt($value)
 * @method static Builder|ProductBookSpineColor whereId($value)
 * @method static Builder|ProductBookSpineColor whereIsPreselected($value)
 * @method static Builder|ProductBookSpineColor whereProductId($value)
 * @method static Builder|ProductBookSpineColor whereSort($value)
 * @method static Builder|ProductBookSpineColor whereStatus($value)
 * @method static Builder|ProductBookSpineColor whereTitle($value)
 * @method static Builder|ProductBookSpineColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductBookSpineColor extends Model implements HasMedia
{
    use HasFactory;
    use MediaTrait;

    protected $fillable = [
        'product_id',
        'title',
        'color',
        'is_preselected',
        'sort',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'title' => 'string',
        'color' => 'string',
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
        return ProductBookSpineColorFactory::new();
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function query(): ProductBookSpineColorQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductBookSpineColorQueryBuilder
    {
        return new ProductBookSpineColorQueryBuilder($query);
    }
}
