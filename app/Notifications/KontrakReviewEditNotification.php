<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Kontrak;

class KontrakReviewEditNotification extends Notification
{
    use Queueable;
    public $kontraks;
    public $namaPengguna;

    /**
     * Create a new notification instance.
     */
    public function __construct($kontraks, $namaPengguna)
    {
        //
        $this->kontraks = $kontraks;
        $this->namaPengguna = $namaPengguna;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Notifikasi Kontrak Telah Diperbaiki')
        ->line('Dear, ' .$this->namaPengguna)
        ->line('Kontrak yang Anda beri revisi telah diperbarui.')
        ->line('Dengan Detail berikut : ')
        ->line('Nomor Kontrak: ' . $this->kontraks->detail_number)
        ->line('Tanggal Kontrak: ' . date('d-m-Y', strtotime($this->kontraks->date_kontrak)))
        ->line('Nomor SOP: ' . $this->kontraks->nomor_sop)
        ->line('Tanggal SOP: ' . date('d-m-Y', strtotime($this->kontraks->tanggal_sop)))
        ->line('Perihal: ' . $this->kontraks->perihal)
        ->line('---------------------------------------------------')
        ->line('Silakan cek kembali kontrak tersebut dihalaman review. Terimakasih')
        ->action('Lihat Kontrak', url('/detailKontrak/{id}' . $this->kontraks->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
