<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DecrementProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        // TODO php artisan make:listener DecrementProductStock --event=OrderPlaced
        DB::transaction(function () use ($event) {
            foreach ($event->order->items()->with('product')->get() as $item) {
                if (is_null($item->product)) {
                    throw new \Exception("Product not found for order item {$item->id}");
                }

                $updated = $item->product()
                    ->where('quantity', '>=', $item->quantity)
                    ->lockForUpdate()
                    ->decrement('quantity', $item->quantity);

                if (!$updated) {
                    throw new \Exception("Insufficient stock for product {$item->product->name}");
                }
            }
        });
    }
}
