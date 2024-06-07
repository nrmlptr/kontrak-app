<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetujuiKontrakNotification extends Notification
{
    use Queueable;
    private $sender;
    private $kontrak;
    private $recipient;


    /**
     * Create a new notification instance.
     */
    public function __construct($sender, $kontrak, $recipient)
    {
        //
        $this->sender       = $sender;
        $this->kontrak      = $kontrak;
        $this->recipient    = $recipient;
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
    public function toArray($notifiable)
    {
        // Mapping kode unit kerja ke alias
        $unitKerjaAlias = [
            '41KDP' => 'Pengadaan',
            '41A10' => 'Investasi',
            '41A20' => 'Jasa Barum',
            '41A30' => 'Lokal',
            '41A40' => 'Import',
            // Tambahkan mapping lainnya sesuai kebutuhan
        ];

        // Ambil semua peran pengirim dan gabungkan menjadi string
        $senderRoles = $this->sender->roles->pluck('name')->implode(', ');

        // Cari alias berdasarkan kode unit kerja, default ke kode itu sendiri jika tidak ditemukan
        $unitKerja = $unitKerjaAlias[$this->sender->unit_kerja] ?? $this->sender->unit_kerja;

        return [
            'title'     => 'Kontrak Telah Disubmit!',
            'kontrak'   => $this->kontrak->id,
            'messages'  => 'Dear ' . $this->recipient->name . ', Kontrak dengan Nomor ' . $this->kontrak->detail_number . ' Telah di Submit oleh ' . $this->sender->name . ' Selaku   ' .  $senderRoles .' '. $unitKerja . '. Silahkan melakukan review kontrak ke tahap selanjutnya, Terimakasih!',
            'url'       => route('showKontrakNotif', $this->kontrak->id),
        ];
    }
}
