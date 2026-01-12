<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'tanggal_masuk',
        'perihal',
        'isi_singkat',
        'file_surat',
        'file_url',
        'status',
        'catatan',
    ];


    protected $casts = [
        'tanggal_masuk' => 'date',
    ];
}
