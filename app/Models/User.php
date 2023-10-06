<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\DiscountRequestStatusEnum;
use App\Enums\RolesEnum;
use App\Models\QueryBuilders\UserQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int                              $id
 * @property string                           $nickname
 * @property string                           $first_name
 * @property string                           $last_name
 * @property string                           $full_name
 * @property RolesEnum                        $role
 * @property string                           $email
 * @property string                           $password
 * @property Carbon|null                      $email_verified_at
 * @property string                           $mobile
 * @property Carbon|null                      $birth_date
 * @property Carbon|null                      $banned_at
 * @property string|null                      $last_login_ip
 * @property Carbon|null                      $last_login_at
 * @property string                           $label
 * @property string                           $locale
 * @property string|null                      $remember_token
 * @property Carbon|null                      $created_at
 * @property Carbon|null                      $updated_at
 * @property Carbon|null                      $deleted_at
 * @property Collection|Transaction           $transactions
 * @property Collection|DiscountRequest       $discount_requests
 *
 * @mixin UserQueryBuilder
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;

    public static string $morph_key = 'user';

    protected $guarded = ['id'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_at'         => 'datetime',
        'last_login_at'     => 'datetime',
        'birth_date'        => 'date',
        //'password'          => 'hashed',
        'role'              => RolesEnum::class,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (User $user) {
            if (($user->isDirty('first_name') && $user->first_name !== null)
                || ($user->isDirty('last_name') && $user->last_name !== null)
            ) {
                $user->full_name = "{$user->first_name} {$user->last_name}";
            }
        });
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return $this->nickname;
    }

    public function preferredLocale()
    {
        return in_array($this->locale, config('app.locales')) ? $this->locale : config('app.locale');
    }

    public function isAdministrator(): bool
    {
        return $this->role === RolesEnum::ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === RolesEnum::USER;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function discount_requests(): HasMany
    {
        return $this->hasMany(DiscountRequest::class, 'user_id', 'id');
    }

    public function availableBalance(): float
    {
        return (
            $this->transactions()->sum('credit') - $this->transactions()->sum('debit')
        );
    }

    public function isWinner(DiscountBox $discountBox): bool
    {
        return $this->discount_requests()
            ->where('user_id', $this->id)
            ->where('discount_box_id', $discountBox->id)
            ->where('status', DiscountRequestStatusEnum::APPROVED)
            ->exists();
    }
}
