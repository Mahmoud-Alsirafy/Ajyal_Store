<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(\Faker\Generator::class, function ($faker, $app) {
            \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($faker);
            return $faker;
        });
        // $this->app->singleton(\App\Services\CurrencyConverter::class, function ($app) {
        //     return new \App\Services\CurrencyConverter();
        // });
        $this->app->bind('currency.converter', fn() => new CurrencyConverter(config('services.currencyapi.key')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        JsonResource::withoutWrapping();
        //!! the listenrs auto called if there is no queue , we can control them here if we want
        //?? Event::listen(OrdenvrPlaced::class, DecrementProductStock::class);
        //?? Event::listen(OrderCreated::class, SendOrderCreatedNotification::class);
        //?? Event::listen(EmptyCart::class, DeleteCart::class);
    }
}