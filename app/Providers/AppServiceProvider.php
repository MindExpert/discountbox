<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\DiscountBox;
use App\Models\Media;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->isProduction() && PHP_OS !== 'Linux') {
            Schema::defaultStringLength(191);
        }

        Paginator::useBootstrap();

        Relation::morphMap([
            Coupon::$morph_key          => Coupon::class,
            DiscountBox::$morph_key     => DiscountBox::class,
            Media::$morph_key           => Media::class,
            Product::$morph_key         => Product::class,
            Transaction::$morph_key     => Transaction::class,
            User::$morph_key            => User::class,

        ]);
    }
}
