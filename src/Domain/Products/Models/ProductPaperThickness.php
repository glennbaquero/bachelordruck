<?php

namespace Domain\Products\Models;

use Database\Factories\ProductPaperThicknessFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\ProductPaperThicknessQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Castables\IntegerCurrency;

/**
 * Domain\Products\Models\ProductPaperThickness
 *
 * @property int $id
 * @property int $product_id
 * @property string $title
 * @property string $tooltip
 * @property int|null $max_pages
 * @property int $price_per_page_bw price in [Cents]
 * @property int $price_per_page_color price in [Cents]
 * @property bool $is_preselected
 * @property int $sort
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\ProductPaperThicknessFactory factory(...$parameters)
 * @method static Builder|ProductPaperThickness newModelQuery()
 * @method static Builder|ProductPaperThickness newQuery()
 * @method static Builder|ProductPaperThickness search(string $searchTerm)
 * @method static Builder|ProductPaperThickness whereCreatedAt($value)
 * @method static Builder|ProductPaperThickness whereId($value)
 * @method static Builder|ProductPaperThickness whereIsPreselected($value)
 * @method static Builder|ProductPaperThickness whereMaxPages($value)
 * @method static Builder|ProductPaperThickness wherePricePerPageBw($value)
 * @method static Builder|ProductPaperThickness wherePricePerPageColor($value)
 * @method static Builder|ProductPaperThickness whereProductId($value)
 * @method static Builder|ProductPaperThickness whereSort($value)
 * @method static Builder|ProductPaperThickness whereStatus($value)
 * @method static Builder|ProductPaperThickness whereTitle($value)
 * @method static Builder|ProductPaperThickness whereTooltip($value)
 * @method static Builder|ProductPaperThickness whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductPaperThickness extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'tooltip',
        'max_pages',
        'price_per_page_bw',
        'price_per_page_color',
        'is_preselected',
        'sort',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'title' => 'string',
        'tooltip' => 'string',
        'max_pages' => 'integer',
        'price_per_page_bw' => IntegerCurrency::class,
        'price_per_page_color' => IntegerCurrency::class,
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
        return ProductPaperThicknessFactory::new();
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

    public static function query(): ProductPaperThicknessQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): ProductPaperThicknessQueryBuilder
    {
        return new ProductPaperThicknessQueryBuilder($query);
    }
}
