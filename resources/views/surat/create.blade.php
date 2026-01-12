@extends('layouts.app')

@section('title', 'Arsipkan Surat Baru')
@section('subtitle', 'Isi detail surat untuk diarsipkan.')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-md border border-slate-200">
        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label for="nomor_surat" class="block text-sm font-medium text-slate-700 mb-2">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" readonly
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm bg-slate-100 focus:outline-none"
                           value="{{ $nomorSurat }}">
                    @error('nomor_surat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pengirim" class="block text-sm font-medium text-slate-700 mb-2">Pengirim</label>
                    <input type="text" name="pengirim" id="pengirim" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                           value="{{ old('pengirim') }}">
                     @error('pengirim')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                           value="{{ old('tanggal_masuk') }}">
                     @error('tanggal_masuk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="perihal" class="block text-sm font-medium text-slate-700 mb-2">Perihal</label>
                    <select name="perihal" id="perihal" required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($kategoriSurat as $kategori)
                            <option value="{{ $kategori->nama }}" {{ old('perihal') == $kategori->nama ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('perihal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="isi_singkat" class="block text-sm font-medium text-slate-700 mb-2">Isi Singkat</label>
                    <textarea name="isi_singkat" id="isi_singkat" rows="4" 
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('isi_singkat') }}</textarea>
                    @error('isi_singkat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="file_surat" class="block text-sm font-medium text-slate-700 mb-2">File Surat (PDF, Doc, Gambar)</label>
                    <input type="file" name="file_surat" id="file_surat" required
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    @error('file_surat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('surat.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    Input Surat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
