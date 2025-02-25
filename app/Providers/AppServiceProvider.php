<?php

namespace App\Providers;

use App\Http\Interfaces\SellingPriceInterface;
use App\Http\Interfaces\UserInterface;
use App\Http\Repositories\SellingPriceRepository;
use App\Http\Repositories\UserRepository;
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
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(SellingPriceInterface::class, SellingPriceRepository::class);
    }
}
