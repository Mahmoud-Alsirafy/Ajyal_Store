<?php

namespace App\Providers;

use App\Events\EmptyCart;
use App\Events\OrderCreated;
use App\Events\OrderPlaced;
use App\Listeners\DecrementProductStock;
use App\Listeners\DeleteCart;
use App\Listeners\SendOrderCreatedNotification;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
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