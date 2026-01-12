<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Surat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    @auth
        <div class="flex min-h-screen">
            <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full transition-all duration-300 z-50">
                <div class="h-16 flex items-center justify-center border-b border-slate-700">
                    <h2 class="text-xl font-bold tracking-wider flex items-center gap-2">
                        <i data-lucide="archive" class="text-sky-400"></i> MANAJEMEN<span class="text-sky-400">SURAT</span>
                    </h2>
                </div>

                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-2">
                        
                        <li>
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ Request::is('dashboard') ? 'bg-sky-600 text-white' : 'text-slate-400' }}">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>

                        <li class="px-4 mt-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Arsip Surat
                        </li>

                        <li>
                            <a href="{{ route('surat.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ Request::is('surat*') ? 'bg-sky-600 text-white' : 'text-slate-400' }}">
                                <i data-lucide="inbox" class="w-5 h-5"></i>
                                <span class="font-medium">Data Surat</span>
                            </a>
                        </li>

                        @can('is_admin')
                        <li class="px-4 mt-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Validasi & Admin
                        </li>

                        <li>
                            <a href="{{ route('surat.validasi') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ Request::is('surat/validasi') ? 'bg-sky-600 text-white' : 'text-slate-400' }}">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                <span class="font-medium">ACC Surat</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ Request::is('users*') ? 'bg-sky-600 text-white' : 'text-slate-400' }}">
                                <i data-lucide="users" class="w-5 h-5"></i>
                                <span class="font-medium">Manajemen User</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('kategori-surat.index') }}"
                                 class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ Request::is('kategori-surat*') ? 'bg-sky-600 text-white' : 'text-slate-400' }}">
                                <i data-lucide="list" class="w-5 h-5"></i>
                                <span class="font-medium">List Perihal</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </nav>

                <div class="border-t border-slate-700 p-4 bg-slate-900">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-sky-500 flex items-center justify-center text-white font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-400" title="Logout">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="flex-1 ml-64 p-8">
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">@yield('title', 'Dashboard')</h1>
                        <p class="text-slate-500 mt-1">@yield('subtitle', 'Selamat datang di sistem arsip digital.')</p>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ now()->format('l, d F Y') }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 min-h-[500px]">
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
