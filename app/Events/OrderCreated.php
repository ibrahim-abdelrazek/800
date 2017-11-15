<?php

namespace App\Events;

use App\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $order;
    protected $receiverId;

    public function __construct(Order $order, $receiverId)
    {
        $this->order = $order;
        $this->receiverId = $receiverId;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order' . $this->receiverId);
    }
    public function broadcastWith() {
        return [
            'partner_id' => $this->order->partner_id,
            'partner_name' => $this->order->partner->name,
            'user_id' => $this->order->owner,
            'user_name' => $this->order->owner->name,
            'user_photo' => asset($this->order->owner->photo),
            'order_id' => $this->order->id,
            'order_time' => $this->order->created_at->diffForHumans()
        ];
    }
}
