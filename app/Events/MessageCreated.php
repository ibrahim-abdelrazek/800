<?php

namespace App\Events;

use App\Messenger\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $message;
    protected $receiverId;

    public function __construct(Message $message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat' . $this->receiverId);
    }
    public function broadcastWith() {
        return [
            'user_id' => $this->message->user->id,
            'user_name' => $this->message->user->name,
            'user_photo' => asset($this->message->user->photo),
            'receiver_id' => $this->message->participants->first()->id,
            'receiver_name' => $this->message->participants->first()->name,
            'receiver_photo' => asset($this->message->participants->first()->photo),
            'message_body' => $this->message->body,
            'message_id' => $this->message->id,
            'message_time' => $this->message->created_at->diffForHumans()
        ];
    }
}
