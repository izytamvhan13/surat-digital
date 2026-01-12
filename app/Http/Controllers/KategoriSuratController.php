<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index()
    {
        $kategoriSurat = KategoriSurat::latest()->paginate(10);
        return view('kategori-surat.index', compact('kategoriSurat'));
    }

    public function create()
    {
        return view('kategori-surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_surats,nama',
        ]);

        KategoriSurat::create($validated);

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('kategori-surat.edit', compact('kategoriSurat'));
    }

    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_surats,nama,' . $kategoriSurat->id,
        ]);

        $kategoriSurat->update($validated);

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori surat berhasil diperbarui.');
    }

    public function destroy(KategoriSurat $kategoriSurat)
    {
        $kategoriSurat->delete();

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori surat berhasil dihapus.');
    }
}
