<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RevisiKontrakNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $revisiKontrak;
    public function __construct($revisiKontrak)
    {
        //
        $this->revisiKontrak = $revisiKontrak;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'kontraks_id' => $this->revisiKontrak->kontraks_id,
            'user_id'     => $this->revisiKontrak->user_id,
            'title'       => 'Revisi Kontrak',
            'messages'    => $this->revisiKontrak->user->name .' Memberikan Revisi pada Kontrak ',
            'url'         => route('showNotifRevisi', $this->revisiKontrak->kontraks_id),
        ];
    }
}
