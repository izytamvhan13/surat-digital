<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use App\Exports\SuratMasukExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Log;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::latest()->paginate(10);
        return view('surat.index', compact('suratMasuk'));
    }

    public function create()
    {
        // Generate nomor surat
        $latestSurat = SuratMasuk::orderBy('id', 'desc')->first();
        $nextId = $latestSurat ? $latestSurat->id + 1 : 1;
        $noUrut = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $month = date('n');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $romanMonth = $romanMonths[$month - 1];

        $year = date('Y');

        $nomorSurat = "{$noUrut}/SRT-DIG/{$romanMonth}/{$year}";
        $kategoriSurat = KategoriSurat::all();

        return view('surat.create', compact('nomorSurat', 'kategoriSurat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            'isi_singkat' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('surat_masuk', $fileName, 'public');
            $validated['file_surat'] = $path;
            $validated['isi_singkat'] = $request->isi_singkat ?? '-';
            $validated['status'] = 'menunggu';

            SuratMasuk::create($validated);

            return redirect()
                ->route('surat.index')
                ->with('success', 'Surat berhasil disimpan dan sedang menunggu validasi.');
        } catch (Exception $e) {
            Log::error('Gagal menambahkan surat', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan surat.')
                ->withInput();
        }
    }

    public function edit(SuratMasuk $surat)
    {
        $kategoriSurat = KategoriSurat::all();
        return view('surat.edit', compact('surat', 'kategoriSurat'));
    }

    public function update(Request $request, SuratMasuk $surat)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'perihal' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            'isi_singkat' => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('file_surat')) {
                if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                    Storage::disk('public')->delete($surat->file_surat);
                }
                $file = $request->file('file_surat');
                $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('surat_masuk', $fileName, 'public');
                $validated['file_surat'] = $path;
            }

            $validated['isi_singkat'] = $request->isi_singkat ?? '-';
            
            $surat->update($validated);

            return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error('Gagal mengedit surat: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui surat.')->withInput();
        }
    }

    public function destroy(SuratMasuk $surat)
    {
        try {
            // Rule: Regular Users (Staff) CANNOT delete a letter if its status is 'disetujui' (Approved).
            if (auth()->user()->is_admin == 0 && $surat->status == 'disetujui') {
                return redirect()->route('surat.index')->with('error', 'Anda tidak dapat menghapus surat yang sudah disetujui.');
            }

            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            $surat->delete();

            return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus!');
        } catch (Exception $e) {
            Log::error('Gagal menghapus surat: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus surat.');
        }
    }

    public function validasi()
    {
        $suratMenunggu = SuratMasuk::where('status', 'menunggu')->latest()->get();
        return view('surat.validasi', compact('suratMenunggu'));
    }

    public function updateStatus(Request $request, SuratMasuk $surat)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $surat->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('surat.validasi')->with('success', 'Status surat berhasil diperbarui.');
    }

    public function export()
    {
        return Excel::download(new SuratMasukExport, 'rekapan-surat-masuk.xlsx');
    }
}
