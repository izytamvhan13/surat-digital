@extends('layouts.guest')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-2xl shadow-md border border-slate-200">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-slate-800">Daftar Akun Baru</h1>
            <p class="mt-2 text-slate-500">Buat akun untuk mulai input surat.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <div class="mt-1">
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                     @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Daftar
                </button>
            </div>
        </form>
         <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-500">
                Login di sini
            </a>
        </p>
    </div>
</div>
@endsection
