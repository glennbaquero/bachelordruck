<?php

namespace Domain\Orders\Models;

use Database\Factories\BasketPositionFactory;
use Domain\Orders\Collections\BasketPositionCollection;
use Domain\Orders\Traits\HasConfiguration;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Castables\IntegerCurrency;

/**
 * Domain\Orders\Models\BasketPosition
 *
 * @property int $id
 * @property string $session_id
 * @property int $product_id
 * @property int $qty
 * @property array|null $configuration
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\BasketPositionFactory factory(...$parameters)
 * @method static Builder|BasketPosition newModelQuery()
 * @method static Builder|BasketPosition newQuery()
 * @method static Builder|BasketPosition query()
 * @method static Builder|BasketPosition search(string $searchTerm)
 * @method static Builder|BasketPosition whereConfiguration($value)
 * @method static Builder|BasketPosition whereCreatedAt($value)
 * @method static Builder|BasketPosition whereId($value)
 * @method static Builder|BasketPosition wherePrice($value)
 * @method static Builder|BasketPosition whereProductId($value)
 * @method static Builder|BasketPosition whereQty($value)
 * @method static Builder|BasketPosition whereSessionId($value)
 * @method static Builder|BasketPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BasketPosition extends Model
{
    use HasFactory;
    use HasConfiguration;

    protected $fillable = [
        'session_id',
        'product_id',
        'qty',
        'configuration',
        'price',
    ];

    protected $casts = [
        'session_id' => 'string',
        'product_id' => 'integer',
        'qty' => 'integer',
        'configuration' => 'array',
        'price' => IntegerCurrency::class,
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('session_id', 'LIKE', '%'.$searchTerm.'%');
//                     ->orWhere('xyz', 'LIKE', '%'.$searchTerm.'%')
    }

    protected static function newFactory()
    {
        return BasketPositionFactory::new();
    }

    public function newCollection(array $models = []): BasketPositionCollection
    {
        return new BasketPositionCollection($models);
    }

    public function getLabelAttribute(): string
    {
        return $this->session_id ?? '';
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
