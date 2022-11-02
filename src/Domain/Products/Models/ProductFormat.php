<?php

namespace Domain\Products\Models;

use Database\Factories\ProductFormatFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductFormatQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \Domain\Products\Models\ProductFormat
 *
 * @property int $id
 * @property int $product_id
 * @property string $title
 * @property bool $is_preselected
 * @property int $sort
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\ProductFormatFactory factory(...$parameters)
 * @method static Builder|ProductFormat newModelQuery()
 * @method static Builder|ProductFormat newQuery()
 * @method static Builder|ProductFormat search(string $searchTerm)
 * @method static Builder|ProductFormat whereCreatedAt($value)
 * @method static Builder|ProductFormat whereId($value)
 * @method static Builder|ProductFormat whereIsPreselected($value)
 * @method static Builder|ProductFormat whereProductId($value)
 * @method static Builder|ProductFormat whereSort($value)
 * @method static Builder|ProductFormat whereStatus($value)
 * @method static Builder|ProductFormat whereTitle($value)
 * @method static Builder|ProductFormat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'is_preselected',
        'sort',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
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
        return ProductFormatFactory::new();
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

    public static function query(): ProductFormatQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductFormatQueryBuilder
    {
        return new ProductFormatQueryBuilder($query);
    }
}
