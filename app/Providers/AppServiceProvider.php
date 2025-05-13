<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CartService;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(CartService::class, function () {
        return new CartService();
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Gate::define('access-admin', function (User $user) {
        return $user->hasRole('admin');
    });
}
}
