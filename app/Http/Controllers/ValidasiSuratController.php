<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\ValidasiSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiSuratController extends Controller
{
    public function index()
    {
        $suratMenunggu = SuratMasuk::whereHas('validasi', function ($query) {
            $query->where('status', 'menunggu');
        })->with('validasi')->latest()->get();
        
        return view('validasi.index', compact('suratMenunggu'));
    }

    public function update(Request $request, SuratMasuk $surat)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_validasi' => 'nullable|string',
        ]);

        $validasi = $surat->validasi;
        if ($validasi) {
            $validasi->update([
                'status' => $request->status,
                'catatan_validasi' => $request->catatan_validasi,
                'validator_id' => Auth::id(),
                'tanggal_validasi' => now(),
            ]);
        }

        return redirect()->route('validasi.index')->with('success', 'Status surat berhasil diperbarui.');
    }
}
