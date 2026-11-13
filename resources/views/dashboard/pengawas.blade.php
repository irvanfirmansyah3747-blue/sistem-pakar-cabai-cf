@extends('layouts.app')

@section('title', 'Dashboard Pengawas & Pakar')

@section('content')
<div class="space-y-6">

    <!-- Header Welcome Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 mb-2">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Panel Utama Pengawas & Pakar Tanaman
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Rumah Semai Helly Seedling
                </h1>
                <p class="text-sm text-emerald-200/90 mt-1 max-w-2xl">
                    Monitoring kondisi kesehatan persemaian bibit cabai, inferensi pakar Certainty Factor, dan distribusi instruksi penanganan hama/penyakit di Desa Srisawahan, Lampung Tengah.
                </p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('diagnosa.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Diagnosa Baru</span>
                </a>
                <a href="{{ route('rules.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-white font-semibold text-sm border border-slate-700 transition flex items-center gap-2">
                    <i data-lucide="sliders" class="w-4 h-4 text-emerald-400"></i>
                    <span>Kelola Aturan CF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Petak -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Petak Semai</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPetak }} <span class="text-sm font-medium text-slate-500">Bedengan</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="grid-3x3" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-slate-600 border-t border-slate-100 pt-3">
                <span class="inline-flex items-center text-emerald-700 font-semibold">
                    <i data-lucide="check" class="w-3.5 h-3.5 mr-0.5"></i> {{ $petakSehat }} Sehat
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="inline-flex items-center text-amber-700 font-semibold">
                    <i data-lucide="alert-triangle" class="w-3.5 h-3.5 mr-0.5"></i> {{ $petakWaspada }} Waspada
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="inline-flex items-center text-rose-700 font-semibold">
                    <i data-lucide="alert-octagon" class="w-3.5 h-3.5 mr-0.5"></i> {{ $petakTerinfeksi }} Terinfeksi
                </span>
            </div>
        </div>

        <!-- Total Bibit Aktif -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Populasi Bibit</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalBibit) }} <span class="text-sm font-medium text-slate-500">Bibit</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i data-lucide="sprout" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-600 border-t border-slate-100 pt-3">
                <i data-lucide="info" class="w-3.5 h-3.5 text-teal-600"></i>
                <span>Bibit Cabai Rawit & Keriting</span>
            </div>
        </div>

        <!-- Total Riwayat Diagnosa -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kasus Diagnosa</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalDiagnosa }} <span class="text-sm font-medium text-slate-500">Kasus</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center justify-between text-xs text-slate-600 border-t border-slate-100 pt-3">
                <span>Riset Certainty Factor</span>
                <span class="text-blue-600 font-semibold">Terekam Digital</span>
            </div>
        </div>

        <!-- Basis Pengetahuan / Rules -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Basis Aturan Pakar</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalRules }} <span class="text-sm font-medium text-slate-500">Rules</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="cpu" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-slate-600 border-t border-slate-100 pt-3">
                <span>{{ $totalPenyakit }} Penyakit</span>
                <span class="text-slate-300">&bull;</span>
                <span>{{ $totalGejala }} Gejala Terdaftar</span>
            </div>
        </div>

    </div>

    <!-- Peta Interaktif Denah Petak Semai (Plot Grid) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="map" class="w-5 h-5 text-emerald-600"></i>
                    Denah Visual Petak Semai (Rumah Semai Helly Seedling)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Status visual kesehatan bedengan bibit cabai di setiap blok greenhouse secara real-time.</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-emerald-500 inline-block"></span> Sehat</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-amber-500 inline-block"></span> Waspada</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-rose-500 inline-block"></span> Terinfeksi</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-slate-300 inline-block"></span> Kosong</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
            @foreach($allPetaks as $petak)
                @php
                    $badge = $petak->status_badge;
                    $borderBg = match($petak->status_kesehatan) {
                        'sehat' => 'border-emerald-200 bg-emerald-50/30 hover:border-emerald-400',
                        'waspada' => 'border-amber-200 bg-amber-50/30 hover:border-amber-400',
                        'terinfeksi' => 'border-rose-200 bg-rose-50/40 hover:border-rose-400',
                        default => 'border-slate-200 bg-slate-50/50 hover:border-slate-300'
                    };
                @endphp
                <div class="p-4 rounded-2xl border {{ $borderBg }} transition-all duration-200 flex flex-col justify-between group shadow-sm hover:shadow">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono tracking-wider {{ $badge['bg'] }} border">
                                {{ $petak->kode_petak }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-600">
                                <i data-lucide="tag" class="w-3 h-3"></i>
                                {{ $petak->lokasi_blok }}
                            </span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition">
                            {{ $petak->nama_petak }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                            <i data-lucide="leaf" class="w-3.5 h-3.5 text-emerald-600"></i>
                            {{ $petak->jenis_cabai }}
                        </p>
                        <div class="mt-3 text-xs text-slate-600 space-y-1 bg-white/70 p-2.5 rounded-xl border border-slate-100">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Populasi:</span>
                                <span class="font-semibold">{{ number_format($petak->jumlah_bibit_aktif) }} / {{ number_format($petak->kapasitas_bibit) }} bibit</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Tgl Semai:</span>
                                <span>{{ $petak->tanggal_semai?->format('d M Y') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                        <span class="text-xs font-semibold {{ $badge['bg'] }} px-2 py-0.5 rounded-full border">
                            {{ $badge['label'] }}
                        </span>
                        <a href="{{ route('petaks.show', $petak->id) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                            <span>Detail Petak</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Charts & Action Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Chart: Sebaran Penyakit Berdasarkan Diagnosa -->
        <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="pie-chart" class="w-5 h-5 text-emerald-600"></i>
                            Statistik Sebaran Penyakit Bibit
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Proporsi hasil diagnosa penyakit cabai di kebun semai.</p>
                    </div>
                </div>
                <div class="h-64 mt-4 flex items-center justify-center">
                    <canvas id="diseaseChart"></canvas>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('laporan.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                    <span>Lihat Laporan Statistik Lengkap</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- Daftar Instruksi & Tugas Lapangan Pending -->
        <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600"></i>
                            Instruksi Penanganan Terkini
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Arahan tindakan penyemprotan obat/fungisida untuk karyawan.</p>
                    </div>
                    <a href="{{ route('tindakans.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">Semua</a>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse($pendingTindakans as $task)
                        <div class="p-3.5 rounded-2xl border border-amber-200/80 bg-amber-50/40 flex items-start justify-between gap-3">
                            <div class="space-y-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800">{{ $task->petak->kode_petak }} - {{ $task->petak->nama_petak }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-800">
                                        {{ $task->status_badge['label'] }}
                                    </span>
                                </div>
                                <p class="text-slate-700 font-medium line-clamp-2">"{{ $task->instruksi_tindakan }}"</p>
                                <p class="text-slate-500 text-[11px] flex items-center gap-2">
                                    <span>Obat: <strong>{{ $task->rekomendasi_pestisida ?? 'Sesuai SOP' }}</strong></span>
                                    <span>&bull;</span>
                                    <span>Petugas: {{ $task->karyawan?->name ?? 'Karyawan Semai' }}</span>
                                </p>
                            </div>
                            <span class="text-[10px] text-slate-500 shrink-0">{{ $task->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400">
                            <i data-lucide="check-circle-2" class="w-10 h-10 mx-auto text-slate-300 mb-2"></i>
                            <p class="text-xs">Tidak ada instruksi darurat yang sedang tertunda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                <a href="{{ route('tindakans.index') }}" class="text-xs font-semibold text-slate-700 hover:text-emerald-700">
                    Buka Panel Tindakan &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Grafik Tren Kasus Diagnosa Harian -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-5 h-5 text-emerald-600"></i>
                    Tren Kejadian Penyakit Bibit Cabai per Tanggal
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Rekam jejak intensitas kasus diagnosa lapangan untuk analisis pola musiman.</p>
            </div>
        </div>
        <div class="h-56 mt-4">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Tabel Riwayat Diagnosa Masuk Terbaru -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-3">
            <div>
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-emerald-600"></i>
                    Diagnosa Lapangan Masuk Terbaru
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar laporan konsultasi penyakit cabai yang dikirimkan oleh karyawan lapangan.</p>
            </div>
            <a href="{{ route('diagnosa.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                <span>Lihat Semua Riwayat ({{ $totalDiagnosa }})</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3 px-3">Kode Tiket</th>
                        <th class="py-3 px-3">Petak Semai</th>
                        <th class="py-3 px-3">Karyawan</th>
                        <th class="py-3 px-3">Hasil Diagnosa Pakar</th>
                        <th class="py-3 px-3 text-center">Akurasi (CF)</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentDiagnosas as $diag)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-3 font-mono font-semibold text-emerald-700">
                                {{ $diag->kode_diagnosa }}
                            </td>
                            <td class="py-3 px-3 font-semibold text-slate-800">
                                {{ $diag->petak->kode_petak }} ({{ $diag->petak->nama_petak }})
                            </td>
                            <td class="py-3 px-3 text-slate-600">
                                {{ $diag->user->name }}
                            </td>
                            <td class="py-3 px-3">
                                <span class="font-bold text-slate-900">{{ $diag->penyakitTerpilih?->nama_penyakit ?? 'Tidak Teridentifikasi' }}</span>
                                <span class="block text-[11px] text-slate-400 italic">{{ $diag->penyakitTerpilih?->nama_latin }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $diag->persentase_cf >= 80 ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $diag->persentase_cf }}%
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $diag->status_badge['class'] }}">
                                    {{ $diag->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="{{ route('diagnosa.show', $diag->id) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold transition">
                                    <span>Hasil & Rumus</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data diagnosa tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rawData = @json($diseaseDistribution);
        const labels = rawData.map(d => d.label);
        const data = rawData.map(d => d.count);

        const ctx = document.getElementById('diseaseChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels.length ? labels : ['Belum Ada Kasus'],
                datasets: [{
                    data: data.length ? data : [1],
                    backgroundColor: [
                        '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6', '#ec4899', '#cbd5e1'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Trend Bar Chart
        const trendRaw = @json($trendData);
        const trendLabels = trendRaw.map(t => t.tanggal);
        const trendCounts = trendRaw.map(t => t.total);

        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'bar',
            data: {
                labels: trendLabels.length ? trendLabels : ['Hari Ini'],
                datasets: [{
                    label: 'Jumlah Kasus Diagnosa',
                    data: trendCounts.length ? trendCounts : [0],
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 28,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush

