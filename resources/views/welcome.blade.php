<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Surat - Kelola Surat Lebih Mudah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    <div class="relative min-h-screen flex flex-col justify-center overflow-hidden">
        
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/Menara_Pandang-BanjarmasinTourism.jpg') }}" 
                 alt="Background Office" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/80 to-slate-900/60"></div>
        </div>

        <header class="absolute top-0 w-full z-20 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm border border-white/20">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Instansi" class="h-10 w-10 object-contain">
                    </div>
                    <span class="text-white font-bold text-xl tracking-wide hidden sm:block">MANAJEMEN<span class="text-sky-400">SURAT</span></span>
                </div>

                @if (Route::has('login'))
                    <nav class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="px-5 py-2.5 rounded-lg bg-sky-600 text-white font-medium hover:bg-sky-500 transition-all shadow-lg hover:shadow-sky-500/30 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-5 py-2.5 rounded-lg text-white font-medium border border-white/20 hover:bg-white/10 transition backdrop-blur-sm">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="px-5 py-2.5 rounded-lg bg-white text-slate-900 font-bold hover:bg-sky-50 transition shadow-lg">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center gap-12">
            
            <div class="flex-1 text-center md:text-left space-y-8 animate-fadeInUp">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-500/10 border border-sky-500/20 text-sky-300 text-sm font-semibold backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                    </span>
                    Sistem Manajemen Surat v1.0
                </div>

                <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight">
                    Kelola Surat <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-emerald-400">Tanpa Batas Ruang.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                    Manajemen
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-4">
                    @auth
                        <a href="{{ url('/surat') }}" 
                           class="inline-flex justify-center items-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-sky-600 hover:bg-sky-500 transition-all shadow-[0_0_20px_rgba(2,132,199,0.5)] hover:shadow-[0_0_30px_rgba(2,132,199,0.6)] transform hover:-translate-y-1">
                            Mulai Mengelola
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex justify-center items-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-sky-600 hover:bg-sky-500 transition-all shadow-[0_0_20px_rgba(2,132,199,0.5)] hover:shadow-[0_0_30px_rgba(2,132,199,0.6)] transform hover:-translate-y-1">
                            Mulai Sekarang
                        </a>
                        <a href="#features" 
                           class="inline-flex justify-center items-center px-8 py-4 text-lg font-bold rounded-xl text-white border border-white/20 hover:bg-white/10 backdrop-blur-sm transition-all">
                            Pelajari Fitur
                        </a>
                    @endauth
                </div>
            </div>

            <div class="flex-1 w-full max-w-md md:max-w-lg relative hidden md:block">
                <div class="relative bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-500">
                    <div class="flex items-center gap-4 mb-6 border-b border-white/10 pb-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-400 to-sky-500 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg">Status Terkini</h3>
                            <p class="text-sky-200 text-sm">Data Real-time</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-slate-400 text-xs uppercase font-bold tracking-wider">Surat Masuk</p>
                            <p class="text-3xl font-bold text-white mt-1">{{ number_format($total_surat) }}</p>
                        </div>
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-slate-400 text-xs uppercase font-bold tracking-wider">Menunggu</p>
                            <p class="text-3xl font-bold text-amber-400 mt-1">{{ number_format($surat_menunggu) }}</p>
                        </div>
                        <div class="col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 flex items-center justify-between">
                            <div>
                                <p class="text-slate-400 text-xs uppercase font-bold tracking-wider">Persetujuan</p>
                                <p class="text-xl font-bold text-emerald-400 mt-1">{{ number_format($persentase, 1) }}%</p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-10 -right-10 w-72 h-72 bg-sky-500/30 rounded-full blur-3xl -z-10 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-emerald-500/30 rounded-full blur-3xl -z-10 animate-pulse delay-700"></div>
            </div>

        </main>

        <footer class="absolute bottom-6 w-full text-center z-20">
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} Sistem Manajemen Surat Instansi. All rights reserved.
            </p>
        </footer>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
</body>
</html>