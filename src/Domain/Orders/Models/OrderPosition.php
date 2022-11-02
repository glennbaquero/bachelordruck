<?php

namespace Domain\Orders\Models;

use Database\Factories\OrderPositionFactory;
use Domain\Orders\Collections\OrderPositionCollection;
use Domain\Orders\Traits\HasConfiguration;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Support\Castables\IntegerCurrency;

/**
 * Domain\Orders\Models\OrderPosition
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $qty
 * @property array|null $configuration
 * @property array|null $product_data all the product data for displaying the position with all details except images. Because products may change or be deleted after the product has been ordered
 * @property int|float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\OrderPositionFactory factory(...$parameters)
 * @method static Builder|OrderPosition newModelQuery()
 * @method static Builder|OrderPosition newQuery()
 * @method static Builder|OrderPosition query()
 * @method static Builder|OrderPosition search(string $searchTerm)
 * @method static Builder|OrderPosition whereConfiguration($value)
 * @method static Builder|OrderPosition whereCreatedAt($value)
 * @method static Builder|OrderPosition whereId($value)
 * @method static Builder|OrderPosition whereOrderId($value)
 * @method static Builder|OrderPosition wherePrice($value)
 * @method static Builder|OrderPosition whereProductData($value)
 * @method static Builder|OrderPosition whereProductId($value)
 * @method static Builder|OrderPosition whereQty($value)
 * @method static Builder|OrderPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderPosition extends Model implements HasMedia
{
    use HasFactory;
    use HasConfiguration;
    use InteractsWithMedia;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'configuration',
        'product_data',
        'price',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'qty' => 'integer',
        'configuration' => 'array',
        'product_data' => 'array',
        'price' => IntegerCurrency::class,
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('id', 'LIKE', '%'.$searchTerm.'%');
//                     ->orWhere('xyz', 'LIKE', '%'.$searchTerm.'%')
    }

    protected static function newFactory()
    {
        return OrderPositionFactory::new();
    }

    public function newCollection(array $models = []): OrderPositionCollection
    {
        return new OrderPositionCollection($models);
    }

    public function getLabelAttribute(): string
    {
        return $this->id ?? '';
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

    public function hasCoverImprint(): bool
    {
        return ! empty($this->configuration['product_cover_color_id']);
    }

    public function shallBurnToCd(): bool
    {
        return $this->configuration['burn_to_cd'];
    }

    public function shallUseCdFilesFromFirstItem(): bool
    {
        return $this->configuration['use_cd_files_from_first_item'];
    }

    public function shallIncludePrintFileInCdBurning(): bool
    {
        return $this->configuration['include_print_file'];
    }
}
