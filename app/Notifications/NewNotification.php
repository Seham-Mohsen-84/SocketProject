<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;


class NewNotification extends Notification implements ShouldBroadcast
{
    use Queueable, Notifiable;
    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'has created new notification!',
        ];
    }

    public function broadcastOn()
    {
       return [new Channel('notification')];
    }

    public function broadcastAs()
    {
        return 'notification.created';
    }


    public function broadcastWith()
    {
        return [
            'message' => 'has created new notification!',
        ];
    }
}
