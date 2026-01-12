<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Log;
use App\Notifications\StatusSuratUpdated;

class SyncStatusFromSheets extends Command
{
    protected $signature = 'surat:sync-status';
    protected $description = 'Sinkronkan status surat dari Google Sheets ke database Laravel (debug mode)';

    public function handle()
    {
        $this->info('Start sync-status');

        // baca dari .env
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $sheetName = env('GOOGLE_SHEET_NAME', 'laporan_surat');
        $credPath = storage_path(env('GOOGLE_CREDENTIALS_PATH', 'credentials/google-service-account.json'));

        if (!$spreadsheetId) {
            $this->error('GOOGLE_SHEET_ID belum diset pada .env');
            return 1;
        }
        if (!file_exists($credPath)) {
            $this->error("Credential file not found: $credPath");
            return 1;
        }

        // setup client
        $client = new Client();
        $client->setAuthConfig($credPath);
        $client->addScope(Sheets::SPREADSHEETS_READONLY);
        $service = new Sheets($client);

        $range = "{$sheetName}!A2:F"; // ambil kolom A..F (A=id, F=status)
        try {
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        } catch (\Exception $e) {
            $this->error('Error fetching sheet: ' . $e->getMessage());
            Log::error('sync-status: fetch error', ['err' => $e->getMessage()]);
            return 1;
        }

        $rows = $response->getValues() ?: [];
        $this->info('Rows fetched: ' . count($rows));

        if (empty($rows)) {
            $this->info('Spreadsheet kosong atau rentang tidak sesuai.');
            return 0;
        }

        $changed = 0;
        foreach ($rows as $rowIndex => $row) {
            $row = array_pad($row, 6, null); // pastikan ada index sampai 5
            $idRaw = $row[0];     // kolom A
            $statusRaw = $row[5]; // kolom F

            $this->line("Row " . ($rowIndex + 2) . ": raw id=" . var_export($idRaw, true) . " raw status=" . var_export($statusRaw, true));

            // normalisasi id
            $id = null;
            if ($idRaw !== null && $idRaw !== '') {
                $id = is_numeric($idRaw) ? (int) $idRaw : trim((string) $idRaw);
            }
            if (!$id) {
                $this->line(" - skip: id kosong / tidak valid");
                continue;
            }

            if ($statusRaw === null) {
                $this->line(" - skip: status kosong");
                continue;
            }

            $normalized = trim(mb_strtolower((string) $statusRaw));
            if (in_array($normalized, ['disetujui', 'setuju', 'ya', 'approved'])) {
                $newStatus = 'Disetujui';
            } elseif (in_array($normalized, ['ditolak', 'tolak', 'no', 'rejected'])) {
                $newStatus = 'Ditolak';
            } elseif ($normalized === '' || $normalized === 'menunggu' || $normalized === 'menunggu persetujuan') {
                $newStatus = 'menunggu';
            } else {
                $this->line(" - unknown status value '" . $statusRaw . "', skipping");
                Log::warning('sync-status: unknown status', ['id' => $id, 'status' => $statusRaw]);
                continue;
            }

            $surat = SuratMasuk::find($id);
            if (!$surat) {
                $this->line(" - skip: surat id {$id} tidak ditemukan di DB");
                continue;
            }

            $this->line(" - DB current status: '" . ($surat->status ?? 'null') . "', newStatus: '$newStatus'");

            if (($surat->status ?? '') !== $newStatus) {
                $surat->status = $newStatus;
                $surat->save();
                event(new \App\Events\StatusSuratUpdatedEvent($surat));
                $changed++;


                // kirim notifikasi database ke semua admin (asumsi is_admin column)
                $admins = \App\Models\User::where('is_admin', true)->get();

                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\SuratStatusUpdatedNotification($surat));
                }

                $this->info(" >> UPDATED surat id {$id} -> {$newStatus}");
                Log::info('sync-status: updated', ['id' => $id, 'status' => $newStatus]);
            } else {
                $this->line(" - no change");
            }
        }

        $this->info("Finished. Total updated: $changed");
        return 0;
    }
}
