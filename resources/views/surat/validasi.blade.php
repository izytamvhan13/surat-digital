@extends('layouts.app')

@section('title', 'ACC Surat Masuk')
@section('subtitle', 'Validasi surat yang diajukan oleh staff.')

@section('content')

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
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratMenunggu as $surat)
            <tr class="bg-white border-b hover:bg-slate-50">
                <td class="px-6 py-4 font-medium text-slate-900">{{ $surat->nomor_surat }}</td>
                <td class="px-6 py-4">{{ $surat->pengirim }}</td>
                <td class="px-6 py-4">{{ $surat->perihal }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($surat->tanggal_masuk)->format('d F Y') }}</td>
                <td class="px-6 py-4 text-center">
                    <button type="button" onclick="openModal('{{ $surat->id }}', 'disetujui')" class="font-medium text-green-600 hover:underline mr-4">Setujui</button>
                    <button type="button" onclick="openModal('{{ $surat->id }}', 'ditolak')" class="font-medium text-red-600 hover:underline">Tolak</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="mail-check" class="w-16 h-16 text-slate-400 mb-4"></i>
                        <h3 class="text-lg font-medium">Tidak ada surat untuk divalidasi</h3>
                        <p class="text-sm">Semua surat masuk telah selesai diproses.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="validation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <form id="validation-form" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <h3 class="text-lg font-bold" id="modal-title"></h3>
                <input type="hidden" name="status" id="modal-status">
                <div class="mt-4">
                    <label for="catatan" class="block text-sm font-medium text-slate-700">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3" class="mt-1 w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-4 rounded-b-lg">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100 transition">Batal</button>
                <button type="submit" id="modal-submit-btn" class="px-4 py-2 text-white rounded-lg transition"></button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(suratId, status) {
        const modal = document.getElementById('validation-modal');
        const form = document.getElementById('validation-form');
        const title = document.getElementById('modal-title');
        const modalStatus = document.getElementById('modal-status');
        const submitBtn = document.getElementById('modal-submit-btn');

        form.action = `/surat/${suratId}/status`;
        modalStatus.value = status;

        if (status === 'disetujui') {
            title.textContent = 'Setujui Surat';
            submitBtn.textContent = 'Ya, Setujui';
            submitBtn.className = 'px-4 py-2 text-white rounded-lg transition bg-green-600 hover:bg-green-700';
        } else {
            title.textContent = 'Tolak Surat';
            submitBtn.textContent = 'Ya, Tolak';
            submitBtn.className = 'px-4 py-2 text-white rounded-lg transition bg-red-600 hover:bg-red-700';
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('validation-modal');
        modal.classList.add('hidden');
    }
    
    // Close modal on escape key press
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
