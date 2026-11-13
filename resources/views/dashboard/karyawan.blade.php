@extends('layouts.app')

@section('title', 'Dashboard Karyawan Lapangan')

@section('content')
<div class="space-y-6">

    <!-- Field Hero Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-700 via-teal-800 to-slate-900 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 mb-2">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Petugas Persemaian Aktif
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Halo, {{ $user->name }}!
                </h1>
                <p class="text-sm text-emerald-200/90 mt-1 max-w-xl">
                    Temukan bibit dengan gejala penyakit di petak semai? Masukkan gejala melalui sistem pakar Certainty Factor untuk mendapatkan rekomendasi penanganan segera.
                </p>
            </div>
            <div>
                <a href="{{ route('diagnosa.create') }}" class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-400 text-slate-950 font-extrabold text-sm shadow-xl shadow-emerald-500/30 hover:scale-105 transition transform">
                    <i data-lucide="scan" class="w-5 h-5"></i>
                    <span>Diagnosa Gejala Bibit Sekarang</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats for Karyawan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Diagnosa Saya</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $myDiagnosasCount }} <span class="text-xs text-slate-500 font-normal">Pemeriksaan</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Tugas / Penanganan Saya</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $myPendingTasks->count() }} <span class="text-xs text-amber-600 font-bold">Perlu Dikerjakan</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="wrench" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Petak Kritis / Waspada</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $petakPerluPerhatian->count() }} <span class="text-xs text-rose-600 font-bold">Perlu Dicek</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i data-lucide="alert-octagon" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Tugas Penanganan Lapangan Dari Pengawas -->
    @if($myPendingTasks->isNotEmpty())
        <div class="bg-amber-50/70 border border-amber-200 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-amber-950">Instruksi Tindakan dari Pengawas</h3>
                    <p class="text-xs text-amber-800">Segera lakukan penanganan dan perbarui status tindakan jika sudah disemprot.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($myPendingTasks as $task)
                    <div class="bg-white rounded-2xl p-4 border border-amber-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold font-mono bg-slate-900 text-white">
                                    {{ $task->petak->kode_petak }}
                                </span>
                                <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full">
                                    {{ $task->status_badge['label'] }}
                                </span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900">{{ $task->petak->nama_petak }}</h4>
                            <p class="text-xs text-slate-700 mt-2 bg-amber-50 p-2.5 rounded-xl border border-amber-100 font-medium">
                                {{ $task->instruksi_tindakan }}
                            </p>
                            @if($task->rekomendasi_pestisida)
                                <div class="mt-2 text-xs text-slate-600">
                                    <strong>Obat/Pestisida:</strong> {{ $task->rekomendasi_pestisida }} ({{ $task->dosis_aplikasi ?? 'Sesuai Dosis' }})
                                </div>
                            @endif
                        </div>

                        <!-- Update Status Form -->
                        <form action="{{ route('tindakans.update-status', $task->id) }}" method="POST" class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <input type="text" name="catatan_pelaksanaan" placeholder="Catatan semprot (misal: selesai disemprot 1 tangki)" class="w-full text-xs px-3 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shrink-0 transition flex items-center gap-1">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                <span>Tandai Selesai</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Denah Lokasi Petak Semai (Sesuai Batasan Hak Akses Karyawan) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="grid-3x3" class="w-5 h-5 text-emerald-600"></i>
                    Lokasi Petak Semai (Helly Seedling)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Pantau status kesehatan bedengan bibit cabai di tempat Anda bertugas.</p>
            </div>
            <a href="{{ route('petaks.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Lihat Semua Petak &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
            @foreach($allPetaks as $petak)
                <div class="p-4 rounded-2xl border {{ $petak->status_kesehatan === 'terinfeksi' ? 'border-rose-300 bg-rose-50/40' : ($petak->status_kesehatan === 'waspada' ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200 bg-slate-50/40') }} flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-0.5 rounded-md text-xs font-mono font-bold bg-slate-800 text-white">
                                {{ $petak->kode_petak }}
                            </span>
                            <span class="text-xs font-semibold {{ $petak->status_badge['bg'] }} px-2 py-0.5 rounded-full border">
                                {{ $petak->status_badge['label'] }}
                            </span>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900">{{ $petak->nama_petak }}</h4>
                        <p class="text-xs text-emerald-700 font-medium mt-1">{{ $petak->jenis_cabai }}</p>
                        <p class="text-[11px] text-slate-500 mt-2">{{ $petak->catatan ?? 'Kondisi terpantau normal.' }}</p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                        <span class="text-[11px] text-slate-500">{{ number_format($petak->jumlah_bibit_aktif) }} bibit aktif</span>
                        <a href="{{ route('diagnosa.create', ['petak_id' => $petak->id]) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                            <span>Periksa Petak Ini</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Diagnosa Terakhir Saya -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-emerald-600"></i>
                    Riwayat Diagnosa Mandiri Saya
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar diagnosa gejala yang pernah Anda submit ke sistem.</p>
            </div>
            <a href="{{ route('diagnosa.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Semua Riwayat Saya &rarr;</a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse($myRecentDiagnosas as $diag)
                <div class="p-4 rounded-2xl border border-slate-200/80 hover:border-emerald-300 hover:bg-emerald-50/20 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-emerald-700">{{ $diag->kode_diagnosa }}</span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="text-xs font-semibold text-slate-800">{{ $diag->petak->kode_petak }} ({{ $diag->petak->nama_petak }})</span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="text-[11px] text-slate-500">{{ $diag->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <p class="text-sm font-bold text-slate-900">
                            {{ $diag->penyakitTerpilih?->nama_penyakit ?? 'Tidak Teridentifikasi' }}
                            <span class="ml-1 text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                Akurasi: {{ $diag->persentase_cf }}%
                            </span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold border {{ $diag->status_badge['class'] }}">
                            {{ $diag->status_badge['label'] }}
                        </span>
                        <a href="{{ route('diagnosa.show', $diag->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white text-xs font-bold transition flex items-center gap-1">
                            <span>Buka Hasil & Solusi</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400">
                    <i data-lucide="clipboard-x" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                    <p class="text-xs">Anda belum pernah melakukan diagnosa mandiri.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

