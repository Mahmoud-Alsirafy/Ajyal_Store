<?php

namespace App\Listeners;

use App\Events\EmptyCart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteCart
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
    public function handle(EmptyCart $event): void
    {
        $event->cart->empty();
    }
}
