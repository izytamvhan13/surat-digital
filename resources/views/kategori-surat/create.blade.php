@extends('layouts.app')

@section('title', 'Tambah Kategori Surat')
@section('subtitle', 'Buat kategori surat baru untuk perihal.')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-md border border-slate-200">
        <form action="{{ route('kategori-surat.store') }}" method="POST">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="nama" id="nama" required 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                       value="{{ old('nama') }}">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('kategori-surat.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
