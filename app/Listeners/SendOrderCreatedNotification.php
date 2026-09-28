<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $user = User::where('store_id', $order->store_id)->first();
        // dd($user);
        if ($user) {
            $user->notify(new OrderCreatedNotification($order));
        }

        // $users = User::where('store_id', $order->store_id)->get();


        // !! to send more than 1 email for the all users
        // Notification::send($users, new OrderCreatedNotification($order));
        // send 1 by 1
        // !! foreach ($users as $suer) {
        // !!  $user->notify(new OrderCreatedNotification($order));
        // !!}
    }
}