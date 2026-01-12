<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\SuratMasuk;

class SuratStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $surat;

    public function __construct(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }

    public function via($notifiable)
    {
        return ['database']; // simpan ke tabel notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Status surat {$this->surat->nomor_surat} telah diperbarui menjadi {$this->surat->status}.",
            'surat_id' => $this->surat->id,
        ];
    }
}
