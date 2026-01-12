<?php

namespace App\Events;

use App\Models\SuratMasuk;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StatusSuratUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $surat;

    public function __construct(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }

    public function broadcastOn()
    {
        return new Channel('status-surat');
    }

    public function broadcastAs()
    {
        return 'status.updated';
    }
}
