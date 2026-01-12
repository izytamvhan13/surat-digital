@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang di Sistem Arsip Digital.')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 flex items-center gap-6">
        <div>
            <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center">
                <i data-lucide="inbox" class="w-8 h-8 text-sky-600"></i>
            </div>
        </div>
        <div>
            <p class="text-slate-500 text-sm">Total Arsip Surat</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalSurat }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 flex items-center gap-6">
        <div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i data-lucide="mail-check" class="w-8 h-8 text-green-600"></i>
            </div>
        </div>
        <div>
            <p class="text-slate-500 text-sm">Surat Disetujui</p>
            <p class="text-2xl font-bold text-slate-800">{{ $suratDisetujui }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 flex items-center gap-6">
        <div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i data-lucide="mail-warning" class="w-8 h-8 text-yellow-600"></i>
            </div>
        </div>
        <div>
            <p class="text-slate-500 text-sm">Surat Menunggu</p>
            <p class="text-2xl font-bold text-slate-800">{{ $suratMenunggu }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 flex items-center gap-6">
        <div>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <i data-lucide="mail-x" class="w-8 h-8 text-red-600"></i>
            </div>
        </div>
        <div>
            <p class="text-slate-500 text-sm">Surat Ditolak</p>
            <p class="text-2xl font-bold text-slate-800">{{ $suratDitolak }}</p>
        </div>
    </div>

</div>

<div class="mt-8 bg-white p-6 rounded-2xl shadow-md border border-slate-200">
    <h3 class="text-lg font-semibold text-slate-800 mb-4">Aktivitas Terbaru</h3>
    <div class="divide-y divide-slate-100">
        @forelse($aktivitasTerbaru as $surat)
            <div class="py-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    @switch($surat->status)
                        @case('menunggu') bg-yellow-100 text-yellow-600 @break
                        @case('disetujui') bg-green-100 text-green-600 @break
                        @case('ditolak') bg-red-100 text-red-600 @break
                    @endswitch
                ">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-slate-800">
                        Surat <span class="font-semibold">{{ $surat->nomor_surat }}</span>
                        telah diupdate dengan status <span class="font-semibold">{{ $surat->status }}</span>
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $surat->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
             <div class="text-center py-8 text-slate-500">
                <i data-lucide="zap-off" class="w-12 h-12 mx-auto text-slate-400"></i>
                <p class="mt-4">Belum ada aktivitas terbaru untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
