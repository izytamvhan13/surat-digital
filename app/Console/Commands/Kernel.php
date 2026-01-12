<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar command artisan kustom.
     */
    protected $commands = [
        \App\Console\Commands\ExportSuratToSheets::class,
        \App\Console\Commands\SyncSuratFromSheets::class,
        \App\Console\Commands\SyncStatusFromSheets::class, // ✅ pastikan command ini sudah dibuat
    ];

    /**
     * Jadwalkan perintah artisan.
     */
    protected function schedule(Schedule $schedule)
    {
        // Jalankan setiap 5 menit untuk update status dari Sheets
        $schedule->command('surat:sync-status')->everyMinutes();
    }

    /**
     * Daftar command artisan yang akan dimuat.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
