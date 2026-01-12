@extends('layouts.app')

@section('title', 'Manajemen User')
@section('subtitle', 'Kelola semua pengguna sistem.')

@section('content')
<div class="mb-6">
    <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-sky-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-sky-700 transition">
        <i data-lucide="plus-circle" class="w-5 h-5"></i>
        Tambah User Baru
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
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Role</th>
                <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="bg-white border-b hover:bg-slate-50">
                <th scope="row" class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                    {{ $user->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $user->is_admin ? 'bg-red-100 text-red-800' : 'bg-sky-100 text-sky-800' }}">
                        {{ $user->is_admin ? 'Admin' : 'Staff' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    {{ $user->created_at->format('d F Y') }}
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('users.edit', $user) }}" class="font-medium text-blue-600 hover:underline mr-4">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-slate-500">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="user-x" class="w-16 h-16 text-slate-400 mb-4"></i>
                        <h3 class="text-lg font-medium">Tidak ada data user</h3>
                        <p class="text-sm">Saat ini belum ada user yang terdaftar di sistem.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
