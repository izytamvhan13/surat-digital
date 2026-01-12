<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\SuratMasuk;

class SuratValidatedNotification extends Notification
{
    use Queueable;

    protected $surat;

    public function __construct(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Surat Divalidasi oleh Pimpinan')
            ->line("Surat dengan nomor: {$this->surat->nomor_surat}")
            ->line("Status baru: {$this->surat->status}")
            ->line("Catatan: {$this->surat->catatan}")
            ->action('Lihat Surat', url('/surat'))
            ->line('Harap periksa sistem untuk detail lebih lanjut.');
    }
}
