<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiSurat extends Model
{
    protected $fillable = [
        'surat_masuk_id',
        'validator_id',
        'status',
        'catatan_validasi',
        'tanggal_validasi',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
