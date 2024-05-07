<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateKontrakNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $updateKontrak;
    private $notifKasek;


    public function __construct($updateKontrak, $notifKasek)
    {
        $this->updateKontrak = $updateKontrak;
        $this->notifKasek = $notifKasek;
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
            'title'     => 'Kontrak Telah Diperbaharui!', 
            'messages'  => $this->updateKontrak->pembuat . ' Telah memperbaharui kontrak dengan Nomor ' . $this->updateKontrak->detail_number . ' Silahkan review kembali. Terimakasih!',
            'url'       => route('showUpdateKontrak', $this->updateKontrak->id),
        ];
    }
}
