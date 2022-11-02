<?php

namespace Domain\Products\Models;

use Database\Factories\ProductCoverColorFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductCoverColorQueryBuilder;
use Domain\Products\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

/**
 * \Domain\Products\Models\ProductCoverColor
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
 * @method static \Database\Factories\ProductCoverColorFactory factory(...$parameters)
 * @method static Builder|ProductCoverColor newModelQuery()
 * @method static Builder|ProductCoverColor newQuery()
 * @method static Builder|ProductCoverColor search(string $searchTerm)
 * @method static Builder|ProductCoverColor whereCreatedAt($value)
 * @method static Builder|ProductCoverColor whereId($value)
 * @method static Builder|ProductCoverColor whereIsPreselected($value)
 * @method static Builder|ProductCoverColor whereProductId($value)
 * @method static Builder|ProductCoverColor whereSort($value)
 * @method static Builder|ProductCoverColor whereStatus($value)
 * @method static Builder|ProductCoverColor whereTitle($value)
 * @method static Builder|ProductCoverColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductCoverColor extends Model implements HasMedia
{
    use HasFactory;
    use MediaTrait;

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
        return ProductCoverColorFactory::new();
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

    public static function query(): ProductCoverColorQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductCoverColorQueryBuilder
    {
        return new ProductCoverColorQueryBuilder($query);
    }
}
