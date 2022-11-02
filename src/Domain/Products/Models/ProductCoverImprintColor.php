<?php

namespace Domain\Products\Models;

use Database\Factories\ProductCoverImprintColorFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductCoverImprintColorQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \Domain\Products\Models\ProductCoverImprintColor
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
 * @method static \Database\Factories\ProductCoverImprintColorFactory factory(...$parameters)
 * @method static Builder|ProductCoverImprintColor newModelQuery()
 * @method static Builder|ProductCoverImprintColor newQuery()
 * @method static Builder|ProductCoverImprintColor search(string $searchTerm)
 * @method static Builder|ProductCoverImprintColor whereColor($value)
 * @method static Builder|ProductCoverImprintColor whereCreatedAt($value)
 * @method static Builder|ProductCoverImprintColor whereId($value)
 * @method static Builder|ProductCoverImprintColor whereIsPreselected($value)
 * @method static Builder|ProductCoverImprintColor whereSort($value)
 * @method static Builder|ProductCoverImprintColor whereStatus($value)
 * @method static Builder|ProductCoverImprintColor whereTitle($value)
 * @method static Builder|ProductCoverImprintColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCoverImprintColor extends Model
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
        return ProductCoverImprintColorFactory::new();
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

    public static function query(): ProductCoverImprintColorQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductCoverImprintColorQueryBuilder
    {
        return new ProductCoverImprintColorQueryBuilder($query);
    }
}
