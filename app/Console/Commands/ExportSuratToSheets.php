<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Sheets;
use App\Models\SuratMasuk;

class ExportSuratToSheets extends Command
{
    protected $signature = 'surat:export-sheets';
    protected $description = 'Kirim semua data surat masuk ke Google Sheets dengan kolom File aktif';

    public function handle()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('credentials/suratdigital-9fb62d000995.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $sheetName = 'laporan_surat';

        $suratMasuk = SuratMasuk::all(['id', 'nomor_surat', 'pengirim', 'tanggal_masuk', 'perihal', 'status', 'catatan', 'file_surat']);

        if ($suratMasuk->isEmpty()) {
            $this->info('Tidak ada surat untuk dikirim.');
            return;
        }

        $values = [
            ['ID', 'Nomor Surat', 'Pengirim', 'Tanggal Masuk', 'Perihal', 'Status', 'Catatan', 'File'],
        ];

        foreach ($suratMasuk as $s) {
            $fileLink = $s->file_surat
                ? asset('storage/' . $s->file_surat)
                : 'Tidak ada file';

            $values[] = [
                $s->id,
                $s->nomor_surat,
                $s->pengirim,
                optional($s->tanggal_masuk)->format('d/m/Y'), // 
                $s->perihal,
                $s->status ?? 'Menunggu Persetujuan',
                $s->catatan ?? '',
                $fileLink,
            ];
        }



        $body = new Sheets\ValueRange(['values' => $values]);
        $service->spreadsheets_values->clear($spreadsheetId, "{$sheetName}!A1:H", new Sheets\ClearValuesRequest());
        $params = ['valueInputOption' => 'RAW'];
        $service->spreadsheets_values->update($spreadsheetId, "{$sheetName}!A1", $body, $params);

        $this->info('✅ Done yee');
    }
}
