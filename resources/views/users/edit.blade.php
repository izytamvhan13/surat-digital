@extends('layouts.app')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui data pengguna.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-md border border-slate-200">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                           value="{{ old('name', $user->name) }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                           value="{{ old('email', $user->email) }}">
                     @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password (Opsional)</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                           placeholder="Isi untuk mengubah password">
                     @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_admin" class="block text-sm font-medium text-slate-700 mb-2">Role / Hak Akses</label>
                    <select name="is_admin" id="is_admin" required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>Staff</option>
                        <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('is_admin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('users.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
