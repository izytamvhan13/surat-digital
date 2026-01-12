<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class SheetsService
{
    protected $spreadsheetId = '1fs2SkmsmgHGNm2bSIVl1NeOHREJdTYn3wS8ph9XWd9E';
    protected $sheetName = 'laporan_surat';

    protected function getClient()
    {
        $client = new Client();
        $credentialsPath = storage_path('credentials/suratdigital-9fb62d000995.json');

        if (!file_exists($credentialsPath)) {
            Log::error("❌ Sheets credentials tidak ditemukan di: " . $credentialsPath);
            return null;
        }

        $client->setAuthConfig($credentialsPath);
        $client->addScope(Sheets::SPREADSHEETS);
        return new Sheets($client);
    }

    public function exportSuratMasuk()
    {
        try {
            $service = $this->getClient();
            if (!$service) {
                Log::warning("⚠️ Sheets service belum siap, ekspor dilewati.");
                return;
            }

            $suratMasuk = SuratMasuk::all([
                'id',
                'nomor_surat',
                'pengirim',
                'tanggal_masuk',
                'perihal',
                'status',
                'file_surat',
                'catatan',
            ]);

            if ($suratMasuk->isEmpty()) {
                Log::info("Tidak ada data surat untuk dikirim ke spreadsheet.");
                return;
            }

            $values = [
                ['ID', 'Nomor Surat', 'Pengirim', 'Tanggal Masuk', 'Perihal', 'Status', 'File', 'Catatan'],
            ];

            foreach ($suratMasuk as $s) {
                $fileCell = $s->file_surat ? asset('storage/' . $s->file_surat) : "Tidak ada file";

                // 🗓️ Format tanggal agar dikenali Google Sheets
                $formattedDate = $s->tanggal_masuk
                    ? Carbon::parse($s->tanggal_masuk)->format('Y-m-d') // Bisa ubah ke 'd/m/Y' kalau mau
                    : '';

                $values[] = [
                    $s->id,
                    $s->nomor_surat,
                    $s->pengirim,
                    $formattedDate,
                    $s->perihal,
                    $s->status ?? 'Menunggu Persetujuan',
                    $fileCell,
                    $s->catatan ?? '',
                ];
            }

            // 🧹 Hapus isi lama sebelum tulis baru
            $clear = new Sheets\ClearValuesRequest();
            $service->spreadsheets_values->clear("{$this->spreadsheetId}", "{$this->sheetName}!A1:H", $clear);

            // 📝 Tulis data baru
            $body = new Sheets\ValueRange([
                'majorDimension' => 'ROWS',
                'values' => $values
            ]);

            $params = ['valueInputOption' => 'USER_ENTERED'];

            $service->spreadsheets_values->update(
                $this->spreadsheetId,
                "{$this->sheetName}!A1",
                $body,
                $params
            );

            // ✅ Tambahkan dropdown validasi
            $this->addDropdownValidation($service, count($values));

            Log::info("✅ Data surat berhasil dikirim ke Google Sheets");
        } catch (Exception $e) {
            Log::error("❌ Gagal ekspor ke Google Sheets: " . $e->getMessage());
        }
    }

    protected function addDropdownValidation($service, $rowCount)
    {
        try {
            $rule = new Sheets\DataValidationRule([
                'condition' => [
                    'type' => 'ONE_OF_LIST',
                    'values' => [
                        ['userEnteredValue' => 'Disetujui'],
                        ['userEnteredValue' => 'Ditolak'],
                    ],
                ],
                'showCustomUi' => true,
                'strict' => true,
            ]);

            $range = new Sheets\GridRange([
                'sheetId' => 0,
                'startRowIndex' => 1,
                'endRowIndex' => $rowCount,
                'startColumnIndex' => 5,
                'endColumnIndex' => 6,
            ]);

            $request = new Sheets\Request([
                'setDataValidation' => [
                    'range' => $range,
                    'rule' => $rule,
                ],
            ]);

            $batch = new Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => [$request],
            ]);

            $service->spreadsheets->batchUpdate($this->spreadsheetId, $batch);
        } catch (Exception $e) {
            Log::warning("⚠️ Gagal set dropdown validation di Google Sheets: " . $e->getMessage());
        }
    }
}
