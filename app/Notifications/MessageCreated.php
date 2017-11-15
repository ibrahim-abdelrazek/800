<?php

namespace App\Notifications;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function toDatabase($notifiable)
    {
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
