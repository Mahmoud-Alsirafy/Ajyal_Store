<?php

use App\Jobs\DeleteExpiredOrders;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Schedule;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Schedule::job(new DeleteExpiredOrders)
    ->everyMinute();