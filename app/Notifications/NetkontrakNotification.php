<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NetkontrakNotification extends Notification
{
    use Queueable;

    private $sender;
    private $kontrak;

    /**
     * Create a new notification instance.
     */
    public function __construct($sender, $kontrak)
    {
        //
        $this->sender  = $sender;
        $this->kontrak = $kontrak;
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

        $senderRoles = $this->sender->roles->pluck('name')->implode(', ');

        return [

            'title'     => 'Kontrak Telah Disetujui (NET KADIV)!',
            'kontrak'   => $this->kontrak->id,
            'messages'  => 'Kontrak dengan Nomor ' . $this->kontrak->detail_number . ' Telah di Approved NET Oleh  ' . $this->sender->name . ' Selaku ' . $senderRoles . '. Terimakasih!',
            'url'       => route('showKontrakNotif', $this->kontrak->id),
        ];
    }
}
