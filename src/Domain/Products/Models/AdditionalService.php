<?php

namespace Domain\Products\Models;

use Database\Factories\AdditionalServiceFactory;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\QueryBuilders\AdditionalServiceQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Castables\IntegerCurrency;
use Support\Helpers\Decimals;

/**
 * \Domain\Products\Models\AdditionalService
 *
 * @property int $id
 * @property string $title
 * @property string $tooltip
 * @property int $surcharge
 * @property int $sort field for order by
 * @property StatusEnum $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\AdditionalServiceFactory factory(...$parameters)
 * @method static Builder|AdditionalService newModelQuery()
 * @method static Builder|AdditionalService newQuery()
 * @method static Builder|AdditionalService search(string $searchTerm)
 * @method static Builder|AdditionalService whereCreatedAt($value)
 * @method static Builder|AdditionalService whereId($value)
 * @method static Builder|AdditionalService whereSort($value)
 * @method static Builder|AdditionalService whereStatus($value)
 * @method static Builder|AdditionalService whereSurcharge($value)
 * @method static Builder|AdditionalService whereTitle($value)
 * @method static Builder|AdditionalService whereTooltip($value)
 * @method static Builder|AdditionalService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdditionalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tooltip',
        'surcharge',
        'sort',
        'status',
    ];

    protected $casts = [
        'title' => 'string',
        'tooltip' => 'string',
        'surcharge' => IntegerCurrency::class,
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
        return AdditionalServiceFactory::new();
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

    public static function query(): AdditionalServiceQueryBuilder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::query();
    }

    public function newEloquentBuilder($query): AdditionalServiceQueryBuilder
    {
        return new AdditionalServiceQueryBuilder($query);
    }

    /**
     * @throws \Exception
     */
    public function surchargeFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->surcharge);
    }

    public function titleWithSurcharge(): Attribute
    {
        return Attribute::get(function () {
            return $this->title.' + '.
                $this->surchargeFormatted.
                ' €';
        });
    }
}
