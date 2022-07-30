<?php

namespace App\Notifications;

use App\Models\Contactus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class Notify extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Contactus $data)
    {
        $this->data = $data;
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

    public function toDatabase($notifiable)
    {

        return [
            'id' => $this->data->id,
            'name' => $this->data->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'read_at' => null,
            'data' => [
                'id' => $this->data->id,
                'name' => $this->data->name,
            ],
        ];
    }
}
