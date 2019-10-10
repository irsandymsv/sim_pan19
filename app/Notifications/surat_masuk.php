<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\SuratMasuk;

class surat_masuk extends Notification
{
    use Queueable;
    protected $surat_masuk;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SuratMasuk $surat)
    {
        $this->surat_masuk = $surat;
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
            'id' => $this->surat_masuk->id,
            'tanggal_diterima' => $this->surat_masuk->tanggal_diterima,
            'pengirim' => $this->surat_masuk->pengirim,
            'perihal' => $this->surat_masuk->perihal
        ];
    }
}
