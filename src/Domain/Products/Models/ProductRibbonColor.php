<?php

namespace Domain\Products\Models;

use Database\Factories\ProductRibbonColorFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductRibbonColorQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \Domain\Products\Models\ProductRibbonColor
 *
 * @property int $id
 * @property string $title
 * @property string $color
 * @property bool $is_preselected
 * @property int $sort
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\ProductRibbonColorFactory factory(...$parameters)
 * @method static Builder|ProductRibbonColor newModelQuery()
 * @method static Builder|ProductRibbonColor newQuery()
 * @method static Builder|ProductRibbonColor search(string $searchTerm)
 * @method static Builder|ProductRibbonColor whereColor($value)
 * @method static Builder|ProductRibbonColor whereCreatedAt($value)
 * @method static Builder|ProductRibbonColor whereId($value)
 * @method static Builder|ProductRibbonColor whereIsPreselected($value)
 * @method static Builder|ProductRibbonColor whereSort($value)
 * @method static Builder|ProductRibbonColor whereStatus($value)
 * @method static Builder|ProductRibbonColor whereTitle($value)
 * @method static Builder|ProductRibbonColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductRibbonColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
        'is_preselected',
        'sort',
        'status',
    ];

    protected $casts = [
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
        return ProductRibbonColorFactory::new();
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

    public static function query(): ProductRibbonColorQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductRibbonColorQueryBuilder
    {
        return new ProductRibbonColorQueryBuilder($query);
    }
}
