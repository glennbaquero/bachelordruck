<?php

namespace Domain\Orders\Models;

use Database\Factories\OrderPaymentFactory;
use Domain\Orders\Enums\IntentEnum;
use Domain\Orders\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'reference',
        'intent',
        'status',
        'response',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'reference' => 'string',
        'intent' => IntentEnum::class,
        'status' => PaymentStatusEnum::class,
        'response' => 'array',
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('reference', 'LIKE', '%'.$searchTerm.'%');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function newFactory()
    {
        return OrderPaymentFactory::new();
    }
}
