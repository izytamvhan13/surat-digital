<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratMasukExport implements FromCollection, WithHeadings, WithMapping
{
    // Ambil semua surat, urut dari yang terbaru
    public function collection()
    {
        return SuratMasuk::orderBy('tanggal_masuk', 'desc')->get();
    }

    // Header kolom di Excel
    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Pengirim',
            'Tanggal Masuk',
            'Perihal',
            'Isi Singkat',
            'Status',
            'Catatan',
        ];
    }

    // Data tiap baris
    public function map($surat): array
    {
        return [
            $surat->nomor_surat ?? '-',
            $surat->pengirim ?? '-',
            $surat->tanggal_masuk ? $surat->tanggal_masuk->format('d-m-Y') : '-',
            $surat->perihal ?? '-',
            $surat->isi_singkat ?? '-',
            ucfirst($surat->status ?? 'Menunggu Persetujuan'),
            $surat->catatan ?? '-',
        ];
    }
}
