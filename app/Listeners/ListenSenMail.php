<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\OrderConfirm;
use Mail;
use Carbon\Carbon;


class ListenSenMail implements ShouldQueue
{
    use InteractsWithQueue;
    
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
    public function handle(SendMail $event): void
    {
        // var_dump($event);
        // dd(Auth::id());
        $cartHtml = $event->cart;
        $order = $event->order;
        $email = $event->email;
        // dd($order);
        Mail::to('levanducdat001@gmail.com')->send(new OrderConfirm($order, $cartHtml));
    }
    public function delay()
    {
        // Ví dụ: delay trong 5 phút
        return Carbon::now()->addMinutes(1);
    }
}
