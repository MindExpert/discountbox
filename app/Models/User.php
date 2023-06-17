<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RolesEnum;
use App\Models\QueryBuilders\UserQueryBuilder;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int                              $id
 * @property int                              $role_id
 * @property string                           $name
 * @property string                           $label
 * @property string                           $email
 * @property string                           $password
 * @property string|null                      $remember_token
 * @property string                           $mobile
 * @property RolesEnum                        $role
 * @property Carbon|null                      $banned_at
 * @property Carbon|null                      $created_at
 * @property Carbon|null                      $updated_at
 * @property Carbon|null                      $deleted_at
 *
 * @mixin UserQueryBuilder
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    //use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id',];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'      => 'hashed',
        'role'          => RolesEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (User $user) {
            //
        });
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }
}
