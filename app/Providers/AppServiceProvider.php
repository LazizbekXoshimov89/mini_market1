<?php

namespace App\Providers;

use App\Http\Interfaces\CategoryInterface;
use App\Http\Interfaces\InvoiceInterface;
use App\Http\Interfaces\MarketInterface;
use App\Http\Interfaces\PartnerInterface;
use App\Http\Interfaces\ProductVariantsInterface;
use App\Http\Interfaces\ReportInterface;
use App\Http\Interfaces\RepositoryActionInterface;
use App\Http\Interfaces\SellingPriceInterface;
use App\Http\Interfaces\UserInterface;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\InvoiceRepository;
use App\Http\Repositories\MarketRepository;
use App\Http\Repositories\PartnerRepository;
use App\Http\Repositories\ProductVariantsRepository;
use App\Http\Repositories\ReportRepository;
use App\Http\Repositories\RepositoryActionRepository;
use App\Http\Repositories\SellingPriceRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(SellingPriceInterface::class, SellingPriceRepository::class);
        $this->app->singleton(RepositoryActionInterface::class, RepositoryActionRepository::class);
        $this->app->singleton(ReportInterface::class, ReportRepository::class);
        $this->app->singleton(ProductVariantsInterface::class, ProductVariantsRepository::class);
        $this->app->singleton(PartnerInterface::class, PartnerRepository::class);
        $this->app->singleton(MarketInterface::class, MarketRepository::class);
        $this->app->singleton(InvoiceInterface::class, InvoiceRepository::class);
        $this->app->singleton(CategoryInterface::class, CategoryRepository::class);
    }
}
