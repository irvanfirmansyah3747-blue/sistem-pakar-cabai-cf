@extends('layouts.app')

@section('title', 'Laporan Statistik Sebaran Penyakit')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-6 h-6 text-emerald-600"></i>
                Laporan Statistik Sebaran Penyakit Bibit Cabai
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Rekapitulasi persebaran insiden penyakit tanaman cabai di Rumah Semai Helly Seedling, Desa Srisawahan.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('laporan.cetak', request()->all()) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <i data-lucide="printer" class="w-4 h-4 text-emerald-400"></i>
                <span>Cetak / Ekspor Laporan Resmi</span>
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Sampai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Filter Petak Semai</label>
                <select name="petak_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Semua Petak --</option>
                    @foreach($allPetaks as $p)
                        <option value="{{ $p->id }}" {{ $petakId == $p->id ? 'selected' : '' }}>
                            {{ $p->kode_petak }} - {{ $p->nama_petak }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Filter Laporan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Penyakit Paling Sering Menyerang -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-emerald-600"></i>
                Frekuensi Kasus per Penyakit
            </h3>

            <div class="space-y-3">
                @forelse($diseaseStats as $stat)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-900">{{ $stat->penyakitTerpilih?->nama_penyakit ?? 'Belum Teridentifikasi' }}</span>
                            <span class="block text-[11px] text-slate-400 italic">{{ $stat->penyakitTerpilih?->nama_latin }}</span>
                        </div>
                        <span class="font-mono font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">
                            {{ $stat->total }} kasus
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Belum ada data diagnosa pada rentang tanggal ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Sebaran Penyakit per Petak Semai -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                <i data-lucide="map-pin" class="w-5 h-5 text-emerald-600"></i>
                Sebaran Insiden per Petak Semai
            </h3>

            <div class="space-y-3">
                @forelse($petakStats as $stat)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-mono font-bold text-slate-900">{{ $stat->petak->kode_petak }}</span>
                            <span class="font-medium text-slate-700 ml-1">({{ $stat->petak->nama_petak }})</span>
                            <span class="block text-[11px] text-emerald-700">{{ $stat->petak->jenis_cabai }}</span>
                        </div>
                        <span class="font-mono font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">
                            {{ $stat->total }} insiden
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Belum ada sebaran insiden pada rentang tanggal ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Data Detail Riwayat Laporan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Rincian Seluruh Riwayat Konsultasi ({{ $diagnosas->count() }} Data)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Petak</th>
                        <th class="py-3 px-4">Karyawan</th>
                        <th class="py-3 px-4">Penyakit Teridentifikasi</th>
                        <th class="py-3 px-4 text-center">Tingkat Keyakinan (CF)</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($diagnosas as $idx => $d)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $d->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $d->petak->kode_petak }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $d->user->name }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $d->penyakitTerpilih?->nama_penyakit ?? '-' }}</td>
                            <td class="py-3 px-4 text-center font-bold text-emerald-700">{{ $d->persentase_cf }}%</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold border {{ $d->status_badge['class'] }}">
                                    {{ $d->status_badge['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

