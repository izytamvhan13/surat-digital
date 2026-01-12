@extends('layouts.guest')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-2xl shadow-md border border-slate-200">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-slate-800">Login</h1>
            <p class="mt-2 text-slate-500">Masuk untuk mengakses surat.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-900">
                        Ingat saya
                    </label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-sky-600 hover:text-sky-500">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Login
                </button>
            </div>
        </form>
        <p class="text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-sky-600 hover:text-sky-500">
                Daftar di sini
            </a>
        </p>
    </div>
</div>
@endsection
