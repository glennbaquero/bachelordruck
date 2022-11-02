<?php

namespace Domain\Users\Models;

use Database\Factories\UserFactory;
use Domain\Pages\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'initials',
        'color',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where('name', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('email', 'LIKE', '%'.$searchTerm.'%');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function getLabelAttribute(): string
    {
        return $this->name ?? '';
    }

    public function getComponentAttribute(): string
    {
        return 'value.user';
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['label'] = $this->label;
        $array['component'] = $this->component;

        return $array;
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
