<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SuratMasuk;

class StatusSuratUpdated extends Notification
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
            ->subject('Status Surat Diperbarui')
            ->line("Surat dengan nomor: {$this->surat->nomor_surat}")
            ->line("Telah diperbarui menjadi: {$this->surat->status}")
            ->action('Lihat Surat', url('/surat'))
            ->line('Mohon ditindaklanjuti sesuai keputusan pimpinan.');
    }
}
