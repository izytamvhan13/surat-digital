<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $totalSurat = SuratMasuk::count();
        $suratDisetujui = SuratMasuk::where('status', 'disetujui')->count();
        $suratDitolak = SuratMasuk::where('status', 'ditolak')->count();
        $suratMenunggu = SuratMasuk::where('status', 'menunggu')->count();

        $aktivitasTerbaru = SuratMasuk::latest()->take(5)->get();

        return view('dashboard', compact('totalSurat', 'suratDisetujui', 'suratDitolak', 'suratMenunggu', 'aktivitasTerbaru'));
    }
}
