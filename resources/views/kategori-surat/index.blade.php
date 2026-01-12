@extends('layouts.app')

@section('title', 'Kategori Surat')
@section('subtitle', 'Daftar semua kategori surat untuk perihal.')

@section('content')
<div class="mb-6">
    <a href="{{ route('kategori-surat.create') }}" class="inline-flex items-center gap-2 bg-sky-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-sky-700 transition">
        <i data-lucide="plus-circle" class="w-5 h-5"></i>
        Tambah Kategori Baru
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-slate-200">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="text-xs text-slate-700 uppercase bg-slate-100">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                <th scope="col" class="px-6 py-3">Dibuat pada</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoriSurat as $kategori)
            <tr class="bg-white border-b hover:bg-slate-50">
                <td class="px-6 py-4 font-medium text-slate-900">{{ $kategori->nama }}</td>
                <td class="px-6 py-4">{{ $kategori->created_at->format('d F Y') }}</td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('kategori-surat.edit', $kategori) }}" class="font-medium text-blue-600 hover:underline mr-4">Edit</a>
                    <form action="{{ route('kategori-surat.destroy', $kategori) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini? Menghapus kategori mungkin akan berpengaruh pada surat yang sudah ada.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-8 text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="folder-open" class="w-16 h-16 text-slate-400 mb-4"></i>
                        <h3 class="text-lg font-medium">Belum ada kategori</h3>
                        <p class="text-sm">Silakan tambahkan kategori surat baru.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $kategoriSurat->links() }}
</div>
@endsection
