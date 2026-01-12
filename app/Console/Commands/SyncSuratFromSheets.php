<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SuratValidatedNotification;

class SyncSuratFromSheets extends Command
{
    protected $signature = 'surat:sync-sheets';
    protected $description = 'Sinkronisasi status surat dari Google Sheets ke database';

    public function handle()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('/credentials/suratdigital-9fb62d000995.json'));
        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        $service = new Sheets($client);
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $range = 'laporan_surat!A2:G'; // asumsi header ada di baris 1

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            $this->info('Spreadsheet kosong.');
            return;
        }

        foreach ($values as $row) {
            if (count($row) < 6)
                continue; // pastikan kolom cukup
            [$id, $nomor, $pengirim, $tanggal, $perihal, $status, $catatan] = array_pad($row, 7, null);

            $surat = SuratMasuk::find($id);
            if (!$surat)
                continue;

            if ($surat->status !== $status || $surat->catatan !== $catatan) {
                $surat->update([
                    'status' => $status,
                    'catatan' => $catatan,
                ]);

                // Kirim notifikasi ke admin
                Notification::route('mail', 'admin@email.com')
                    ->notify(new SuratValidatedNotification($surat));

                $this->info("Surat ID {$id} diperbarui: {$status}");
            }
        }

        $this->info('Sinkronisasi selesai!');
    }
}
