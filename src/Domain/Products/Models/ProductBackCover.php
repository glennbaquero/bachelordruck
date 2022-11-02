<?php

namespace Domain\Products\Models;

use Database\Factories\ProductBackCoverFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductBackCoverQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \Domain\Products\Models\ProductBackCover
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
 * @method static \Database\Factories\ProductBackCoverFactory factory(...$parameters)
 * @method static Builder|ProductBackCover newModelQuery()
 * @method static Builder|ProductBackCover newQuery()
 * @method static Builder|ProductBackCover search(string $searchTerm)
 * @method static Builder|ProductBackCover whereColor($value)
 * @method static Builder|ProductBackCover whereCreatedAt($value)
 * @method static Builder|ProductBackCover whereId($value)
 * @method static Builder|ProductBackCover whereIsPreselected($value)
 * @method static Builder|ProductBackCover whereSort($value)
 * @method static Builder|ProductBackCover whereStatus($value)
 * @method static Builder|ProductBackCover whereTitle($value)
 * @method static Builder|ProductBackCover whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductBackCover extends Model
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
        return ProductBackCoverFactory::new();
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

    public static function query(): ProductBackCoverQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductBackCoverQueryBuilder
    {
        return new ProductBackCoverQueryBuilder($query);
    }
}
