<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;

class TestSheets extends Command
{
    protected $signature = 'test:sheets';
    protected $description = 'Test koneksi ke Google Sheets API';

    public function handle()
    {
        $client = new Client();
        $client->setApplicationName('Surat Digital');
        $client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $client->useApplicationDefaultCredentials();

        $service = new Sheets($client);

        // 👉 Ganti ini dengan ID spreadsheet kamu
        $spreadsheetId = '1fs2SkmsmgHGNm2bSIVl1NeOHREJdTYn3wS8ph9XWd9E';
        $range = 'Sheet1!A1:B5';

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            $this->info("Spreadsheet kosong atau tidak ditemukan.");
        } else {
            foreach ($values as $row) {
                $this->info(implode(' | ', $row));
            }
        }
    }
}
