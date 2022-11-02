<?php

namespace Domain\Products\Models;

use Database\Factories\ProductBookCornerColorFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductBookCornerColorQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \Domain\Products\Models\ProductBookCornerColor
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
 * @method static \Database\Factories\ProductBookCornerColorFactory factory(...$parameters)
 * @method static Builder|ProductBookCornerColor newModelQuery()
 * @method static Builder|ProductBookCornerColor newQuery()
 * @method static Builder|ProductBookCornerColor search(string $searchTerm)
 * @method static Builder|ProductBookCornerColor whereColor($value)
 * @method static Builder|ProductBookCornerColor whereCreatedAt($value)
 * @method static Builder|ProductBookCornerColor whereId($value)
 * @method static Builder|ProductBookCornerColor whereIsPreselected($value)
 * @method static Builder|ProductBookCornerColor whereSort($value)
 * @method static Builder|ProductBookCornerColor whereStatus($value)
 * @method static Builder|ProductBookCornerColor whereTitle($value)
 * @method static Builder|ProductBookCornerColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductBookCornerColor extends Model
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
        return ProductBookCornerColorFactory::new();
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

    public static function query(): ProductBookCornerColorQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductBookCornerColorQueryBuilder
    {
        return new ProductBookCornerColorQueryBuilder($query);
    }
}
