@extends('layouts.app')

@section('title', 'Data Surat Masuk')
@section('subtitle', 'Semua surat yang telah masuk dalam sistem.')

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('surat.create') }}" class="inline-flex items-center gap-2 bg-sky-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-sky-700 transition">
        <i data-lucide="plus-circle" class="w-5 h-5"></i>
        Tambah Surat Baru
    </a>
    @can('is_admin')
    <a href="{{ route('surat.export') }}" class="inline-flex items-center gap-2 bg-green-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700 transition">
        <i data-lucide="download" class="w-5 h-5"></i>
        Ekspor Rekapan
    </a>
    @endcan
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
                <th scope="col" class="px-6 py-3">Nomor Surat</th>
                <th scope="col" class="px-6 py-3">Pengirim</th>
                <th scope="col" class="px-6 py-3">Perihal</th>
                <th scope="col" class="px-6 py-3">Tanggal Masuk</th>
                <th scope="col" class="px-6 py-3 text-center">Status Validasi</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratMasuk as $surat)
            <tr class="bg-white border-b hover:bg-slate-50">
                <td class="px-6 py-4 font-medium text-slate-900">{{ $surat->nomor_surat }}</td>
                <td class="px-6 py-4">{{ $surat->pengirim }}</td>
                <td class="px-6 py-4">{{ Str::limit($surat->perihal, 50) }}</td>
                <td class="px-6 py-4">{{ $surat->tanggal_masuk->format('d F Y') }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @switch($surat->status)
                            @case('menunggu')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('disetujui')
                                bg-green-100 text-green-800
                                @break
                            @case('ditolak')
                                bg-red-100 text-red-800
                                @break
                        @endswitch
                    ">
                        {{ ucfirst($surat->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ url('storage/' . $surat->file_surat) }}" target="_blank" class="font-medium text-sky-600 hover:underline mr-4">Lihat</a>
                    <a href="{{ route('surat.edit', $surat) }}" class="font-medium text-blue-600 hover:underline mr-4">Edit</a>
                    <form action="{{ route('surat.destroy', $surat) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus surat ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-8 text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="inbox" class="w-16 h-16 text-slate-400 mb-4"></i>
                        <h3 class="text-lg font-medium">Belum ada surat</h3>
                        <p class="text-sm">Silakan tambahkan surat baru.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $suratMasuk->links() }}
</div>
@endsection