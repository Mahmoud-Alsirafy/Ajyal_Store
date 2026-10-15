<?php

namespace App\Console\Commands;

use App\Jobs\DeleteExpiredOrders;
use Illuminate\Console\Command;

class DeleteExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('i am on the comand');
        dispatch(new DeleteExpiredOrders());
    }
}