<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Cart;
use App\Models\Order;


class SendMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    public $cart;
    public $email;
    /**
     * Create a new event instance.
     */
    public function __construct($email,Order $order,$cart)
    {
        $this->order = $order;
        $this->email = $email;
        $this->cart = $cart;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
