<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriSurat;

class KategoriSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriSurat::create(['nama' => 'Undangan']);
        KategoriSurat::create(['nama' => 'Pemberitahuan']);
        KategoriSurat::create(['nama' => 'Permohonan']);
        KategoriSurat::create(['nama' => 'Laporan']);
        KategoriSurat::create(['nama' => 'Keputusan']);
    }
}
