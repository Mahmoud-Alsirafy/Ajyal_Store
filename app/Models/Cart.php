<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    protected static function booted()
    {
        // TODO: php artisan make:observer CartObserver --model=Cart
        static::observe(CartObserver::class);
        // static::creating(function (Cart $cart) {
        //     $cart->id = Str::uuid();
        // });

        static::addGlobalScope(
            'cookie_id',
            fn(Builder $builder) =>
            $builder->where(
                'cookie_id',
                Cart::getCooieId()
            )
        );
    }

    public static function getCooieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (! $cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 7);
        }
        return $cookie_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'anonymous',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
