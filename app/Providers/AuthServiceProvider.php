<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\DiscountBox;
use App\Models\Product;
use App\Models\User;
use App\Policies\CouponPolicy;
use App\Policies\DiscountBoxPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Coupon::class       => CouponPolicy::class,
        DiscountBox::class  => DiscountBoxPolicy::class,
        Product::class      => ProductPolicy::class,
        User::class         => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //Gate::define('access', function (?User $user) {
        //    return $user?->can('viewAny', User::class);
        //});
    }
}
