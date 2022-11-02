<?php

namespace Domain\Orders\Models;

use App\Enums\SalutationEnum;
use Database\Factories\OrderFactory;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Support\Castables\IntegerCurrency;

/**
 * \Domain\Orders\Models\Order
 *
 * @property int $id
 * @property string $session_id
 * @property SalutationEnum|null $title
 * @property string $firstname
 * @property string $lastname
 * @property string|null $company
 * @property string|null $name_affix additional name line for portal address
 * @property string $street
 * @property string $postal_code
 * @property string $city
 * @property string $country
 * @property string $email
 * @property string|null $phone
 * @property int $total_amount
 * @property PaymentEnum $payment
 * @property StatusEnum $status
 * @property string $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $label
 *
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order search(string $searchTerm)
 * @method static Builder|Order whereCity($value)
 * @method static Builder|Order whereCompany($value)
 * @method static Builder|Order whereCountry($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereFirstname($value)
 * @method static Builder|Order whereGender($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereLastname($value)
 * @method static Builder|Order whereNameAffix($value)
 * @method static Builder|Order wherePayment($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order wherePostalCode($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereStreet($value)
 * @method static Builder|Order whereTitle($value)
 * @method static Builder|Order whereTotalAmount($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property CustomerTypeEnum $customer_type
 * @property bool $is_recipient_different
 * @property SalutationEnum|null $recipient_title
 * @property string|null $recipient_firstname
 * @property string|null $recipient_lastname
 * @property string|null $recipient_street
 * @property string|null $recipient_postal_code
 * @property string|null $recipient_city
 *
 * @method static Builder|Order whereCustomerType($value)
 * @method static Builder|Order whereIsRecipientDifferent($value)
 * @method static Builder|Order whereRecipientCity($value)
 * @method static Builder|Order whereRecipientFirstname($value)
 * @method static Builder|Order whereRecipientLastname($value)
 * @method static Builder|Order whereRecipientPostalCode($value)
 * @method static Builder|Order whereRecipientStreet($value)
 * @method static Builder|Order whereRecipientTitle($value)
 */
class Order extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'session_id',
        'customer_type',
        'title',
        'firstname',
        'lastname',
        'email',
        'phone',
        'street',
        'postal_code',
        'city',

        'is_recipient_different',

        'recipient_title',
        'recipient_firstname',
        'recipient_lastname',
        'recipient_street',
        'recipient_postal_code',
        'recipient_city',

        'total_amount',
        'payment',
        'status',

        'completed_at',
    ];

    protected $casts = [
        'session_id' => 'string',
        'customer_type' => CustomerTypeEnum::class,
        'title' => SalutationEnum::class,
        'firstname' => 'string',
        'lastname' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'street' => 'string',
        'postal_code' => 'string',
        'city' => 'string',

        'is_recipient_different' => 'boolean',

        'recipient_title' => SalutationEnum::class,
        'recipient_firstname' => 'string',
        'recipient_lastname' => 'string',
        'recipient_street' => 'string',
        'recipient_postal_code' => 'string',
        'recipient_city' => 'string',

        'total_amount' => IntegerCurrency::class,
        'payment' => PaymentEnum::class,
        'status' => StatusEnum::class,

        'completed_at' => 'datetime',
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
        return OrderFactory::new();
    }

    public function getLabelAttribute(): string
    {
        return $this->title ?? '';
    }

    public function orderPositions()
    {
        return $this->hasMany(OrderPosition::class);
    }

    public function orderPayment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::get(function () {
            return implode(' ', [$this->title->label(), $this->firstname, $this->lastname]);
        });
    }

    public function address(): Attribute
    {
        return Attribute::get(function () {
            return $this->street.', '.implode(' ', [$this->postal_code, $this->city]);
        });
    }

    public function recipientFullName(): Attribute
    {
        return Attribute::get(function () {
            return implode(' ', [$this->recipient_title->label(), $this->recipient_firstname, $this->recipient_lastname]);
        });
    }

    public function recipientAddress(): Attribute
    {
        return Attribute::get(function () {
            return $this->recipient_street.', '.implode(' ', [$this->recipient_postal_code, $this->recipient_city]);
        });
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }
}
