<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Guest Customer']);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')->using(OrderItem::class)->withPivot([
            'product_name',
            'price',
            'quantity',
            'options'
        ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddresses::class);
    }

    public function  billingAddress()
    {
        return $this->hasOne(OrderAddresses::class, 'order_id', 'id')->where('type', 'billing');
    }

    public function  ShipppingAddress()
    {
        return $this->hasOne(OrderAddresses::class, 'order_id', 'id')->where('type', 'shipping');
    }

    protected static function booted()
    {
        static::creating(fn(Order $order) => $order->number = Order::getNextOrderNumber());
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
