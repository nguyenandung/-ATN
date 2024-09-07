<?php

namespace App\Listeners;

use App\Events\VoucherCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
// use 

class SendVoucherNotification
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
    public function handle(VoucherCreated $event): void
    {
        $voucherMa = $event->voucher;
        // $id = $event->id;
        // dd($voucherMa);

    }
}
