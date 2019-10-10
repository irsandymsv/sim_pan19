<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\SuratKeluar;

class surat_keluar extends Notification
{
    use Queueable;
    protected $surat_keluar;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SuratKeluar $surat)
    {
        $this->surat_keluar = $surat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'id' => $this->surat_keluar->id,
            'nomor_surat' => $this->surat_keluar->nomor_surat,
            'tanggal_surat' => $this->surat_keluar->tanggal_surat,
            'tujuan' => $this->surat_keluar->tujuan,
            'perihal' => $this->surat_keluar->perihal,
            'status' => $this->surat_keluar->status,
        ];
    }
}
