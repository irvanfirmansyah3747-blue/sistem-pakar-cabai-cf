<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pakar Cabai') - Helly Seedling</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full flex text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" x-cloak>
    </div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-emerald-950 text-white flex flex-col transition-transform duration-300 ease-in-out shadow-2xl">
        
        <!-- Logo Brand -->
        <div class="px-6 py-6 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i data-lucide="sprout" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-white flex items-center gap-1.5">
                        Helly Seedling
                    </h1>
                    <p class="text-xs text-emerald-400/90 font-medium">Sistem Pakar Cabai (CF)</p>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Role Badge -->
        <div class="px-6 py-3 bg-slate-800/40 border-b border-slate-800/60 flex items-center justify-between">
            <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Otoritas Akses</span>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ auth()->user()->isPengawas() ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isPengawas() ? 'bg-amber-400' : 'bg-emerald-400' }}"></span>
                {{ auth()->user()->isPengawas() ? 'Pengawas (Pakar)' : 'Karyawan Lapangan' }}
            </span>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-3 pb-1">
                <span class="px-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pemeriksaan & Lapangan</span>
            </div>

            <a href="{{ route('diagnosa.create') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('diagnosa.create') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-emerald-300 bg-emerald-950/40 hover:bg-emerald-900/60 hover:text-white border border-emerald-800/40' }}">
                <i data-lucide="stethoscope" class="w-5 h-5 text-emerald-400"></i>
                <span>Mulai Diagnosa Baru</span>
                <span class="ml-auto text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/30 text-emerald-200 font-bold uppercase">CF</span>
            </a>

            <a href="{{ route('diagnosa.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('diagnosa.index*') && !request()->routeIs('diagnosa.create') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>Riwayat Diagnosa</span>
            </a>

            <a href="{{ route('petaks.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('petaks.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="grid-3x3" class="w-5 h-5"></i>
                <span>Peta & Lokasi Petak</span>
            </a>

            <a href="{{ route('tindakans.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('tindakans.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
                <span>Instruksi & Penanganan</span>
            </a>

            <a href="{{ route('penyakits.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('penyakits.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <span>Katalog Penyakit Cabai</span>
            </a>

            <!-- KHUSUS MENU PENGAWAS (HAK PENUH SKRIPSI) -->
            @if(auth()->user()->isPengawas())
                <div class="pt-4 pb-1">
                    <span class="px-3.5 text-xs font-semibold text-amber-400 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="crown" class="w-3.5 h-3.5"></i>
                        Menu Master Pengawas
                    </span>
                </div>

                <a href="{{ route('gejalas.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('gejalas.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                    <span>Data Gejala</span>
                </a>

                <a href="{{ route('rules.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('rules.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="sliders" class="w-5 h-5"></i>
                    <span>Basis Aturan & CF Pakar</span>
                </a>

                <a href="{{ route('laporan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('laporan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    <span>Laporan Statistik Sebaran</span>
                </a>

                <a href="{{ route('karyawan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('karyawan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Manajemen Akun Karyawan</span>
                </a>
            @endif
        </nav>

        <!-- User Profile Card in Sidebar -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center font-bold text-white text-sm shadow">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <!-- Quick Role Switcher for Demo / UTS -->
            <div class="pt-2 border-t border-slate-800/60 flex items-center justify-between text-xs">
                <span class="text-slate-400">Ganti Akun Demo:</span>
                <div class="flex gap-1.5">
                    <a href="{{ route('quick.login', 'pengawas') }}" class="px-2 py-0.5 rounded text-[11px] font-semibold {{ auth()->user()->isPengawas() ? 'bg-amber-500 text-slate-900' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}" title="Masuk sebagai Pengawas">Pakar</a>
                    <a href="{{ route('quick.login', 'karyawan') }}" class="px-2 py-0.5 rounded text-[11px] font-semibold {{ auth()->user()->isKaryawan() ? 'bg-emerald-500 text-slate-900' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}" title="Masuk sebagai Karyawan">Karyawan</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-72">
        
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-8">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div class="hidden sm:block">
                    <span class="text-xs font-medium text-slate-500">Objek Riset:</span>
                    <span class="text-xs font-semibold text-slate-700 ml-1">Rumah Semai Helly Seedling, Lampung Tengah</span>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Quick Diagnosa Button -->
                <a href="{{ route('diagnosa.create') }}" class="hidden md:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Diagnosa Gejala</span>
                </a>

                <!-- User Dropdown & Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Flash Notifications -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 shadow-sm animate-fade-in" x-data="{ show: true }" x-show="show">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-rose-600 shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium text-rose-800">
                        {{ session('error') }}
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium text-blue-800">
                        {{ session('info') }}
                    </div>
                    <button @click="show = false" class="text-blue-500 hover:text-blue-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm text-rose-800">
                        <p class="font-bold mb-1">Mohon periksa kembali isian formulir:</p>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500">
            <p>
                <strong>Sistem Pakar Diagnosa Penyakit Bibit Tanaman Cabai</strong> • Metode Certainty Factor & Forward Chaining
            </p>
            <p class="mt-0.5 text-slate-400">
                Studi Kasus: Rumah Semai Helly Seedling, Desa Srisawahan, Lampung Tengah &copy; 2026
            </p>
        </footer>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>

