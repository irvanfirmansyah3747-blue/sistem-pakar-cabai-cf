<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pakar Cabai Helly Seedling</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-950 relative overflow-hidden">

    <!-- Decorative Glow Circles -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-4xl bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- Left Column: Branding & Info -->
        <div class="lg:col-span-5 bg-gradient-to-br from-emerald-900 via-slate-900 to-slate-950 p-8 sm:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-slate-800 text-white relative">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/30 mb-6">
                    <i data-lucide="sprout" class="w-8 h-8 text-white"></i>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-white">
                    Sistem Pakar Diagnosa Penyakit Bibit Cabai
                </h2>
                <p class="text-sm text-emerald-400 mt-1 font-medium">Metode Certainty Factor (CF)</p>

                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200">Rumah Semai Helly Seedling</p>
                            <p class="text-[11px] text-slate-400">Desa Srisawahan, Kab. Lampung Tengah</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="cpu" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200">Mesin Inferensi Cerdas</p>
                            <p class="text-[11px] text-slate-400">Forward Chaining & Probabilitas Certainty Factor</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-300"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200">Validasi Pakar Tanaman</p>
                            <p class="text-[11px] text-slate-400">Data teruji bersama Bpk. Helly Sumanto & Pakar</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 text-[11px] text-slate-500 border-t border-slate-800/80">
                Tugas Akhir Skripsi & Basis Data Lanjut &bull; 2026
            </div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center">
            
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white">Masuk ke Portal Sistem</h3>
                <p class="text-xs text-slate-400 mt-1">Silakan masukkan nama pengguna atau email terdaftar.</p>
            </div>

            @if(session('error'))
                <div class="mb-5 p-3 rounded-xl bg-rose-950/60 border border-rose-800/60 text-xs text-rose-300 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3 rounded-xl bg-rose-950/60 border border-rose-800/60 text-xs text-rose-300 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                        Username / Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="login" required autofocus value="{{ old('login') }}"
                               placeholder="pengawas atau karyawan"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-800/60 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-800/60 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-800 border-slate-700 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-slate-900">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 font-bold rounded-xl shadow-lg shadow-emerald-500/25 transition flex items-center justify-center gap-2 text-sm mt-2">
                    <span>Masuk ke Sistem</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <!-- 1-Click Fast Login Demonstration Switcher -->
            <div class="mt-8 pt-6 border-t border-slate-800">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-3 text-center">
                    Akses Cepat Pengujian / Demo
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('quick.login', 'pengawas') }}" 
                       class="p-2.5 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-amber-500/30 hover:border-amber-500/60 transition group flex flex-col items-center text-center">
                        <span class="text-xs font-bold text-amber-300 group-hover:text-amber-200 flex items-center gap-1">
                            <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                            Role Pengawas (Pakar)
                        </span>
                        <span class="text-[10px] text-slate-400 mt-0.5">Akses penuh kelola master & aturan</span>
                    </a>

                    <a href="{{ route('quick.login', 'karyawan') }}" 
                       class="p-2.5 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-emerald-500/30 hover:border-emerald-500/60 transition group flex flex-col items-center text-center">
                        <span class="text-xs font-bold text-emerald-300 group-hover:text-emerald-200 flex items-center gap-1">
                            <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                            Role Karyawan
                        </span>
                        <span class="text-[10px] text-slate-400 mt-0.5">Input gejala semai & pantau petak</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

