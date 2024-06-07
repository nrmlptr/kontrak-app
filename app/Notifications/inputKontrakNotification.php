<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class inputKontrakNotification extends Notification
{
    use Queueable;

    private $pembuatKontrak;
    private $notifKasek;

    /**
     * Create a new notification instance.
     */
    public function __construct($pembuatKontrak, $notifKasek)
    {
        //

        $this->notifKasek = $notifKasek;
        $this->pembuatKontrak = $pembuatKontrak;
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
            'title'         => 'Kontrak Baru Telah Dibuat!',
            'messages'      =>  $this->pembuatKontrak->pembuat . ' Telah membuat kontrak baru, silahkan melakukan review. Terimakasih!',
            'url'           => route('Kontrakshow1', $this->pembuatKontrak->id),
        ];
    }
}
