<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;

class SuratMasukSeeder extends Seeder
{

    public function run()
    {
        SuratMasuk::create([
            'nomor_surat'   => '001/DINAS/I/2026',
            'pengirim'      => 'Dinas Pendidikan',
            'tanggal_masuk' => '2026-01-08',
            'perihal'       => 'Undangan Rapat Koordinasi',
            'isi_singkat'   => 'Rapat pembahasan kurikulum tahun ajaran baru.',
            'status'        => 'menunggu',
            'file_surat'    => null, 
        ]);

        SuratMasuk::create([
            'nomor_surat'   => '002/MITRA/I/2026',
            'pengirim'      => 'CV. Teknologi Maju',
            'tanggal_masuk' => '2026-01-07',
            'perihal'       => 'Penawaran Kerjasama Web',
            'isi_singkat'   => 'Proposal penawaran maintenance website dinas.',
            'status'        => 'disetujui',
            'catatan'       => 'Segera jadwalkan pertemuan teknis.',
            'file_surat'    => null,
        ]);

        SuratMasuk::create([
            'nomor_surat'   => '003/UMUM/I/2026',
            'pengirim'      => 'Organisasi Masyarakat',
            'tanggal_masuk' => '2026-01-06',
            'perihal'       => 'Permohonan Dana Hibah',
            'isi_singkat'   => 'Pengajuan dana untuk acara bakti sosial.',
            'status'        => 'ditolak',
            'catatan'       => 'Maaf, anggaran tahun ini sudah tutup.',
            'file_surat'    => null,
        ]);
    }
}