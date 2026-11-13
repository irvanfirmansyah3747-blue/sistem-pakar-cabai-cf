@extends('layouts.app')

@section('title', 'Instruksi & Penanganan Penyakit')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="shield-alert" class="w-6 h-6 text-emerald-600"></i>
                Instruksi & Penanganan Penyakit Semai
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Monitoring pelaksanaan arahan pengawas dan catatan penyemprotan fungisida/bakterisida di kebun semai.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200">
                Total Instruksi: {{ $tindakans->total() }}
            </span>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-4 shadow-sm flex items-center gap-3">
        <span class="text-xs font-semibold text-slate-500">Filter Status:</span>
        <div class="flex flex-wrap gap-2 text-xs">
            <a href="{{ route('tindakans.index') }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ !request('status') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('tindakans.index', ['status' => 'menunggu']) }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ request('status') === 'menunggu' ? 'bg-amber-500 text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Menunggu Dikerjakan
            </a>
            <a href="{{ route('tindakans.index', ['status' => 'sedang_dikerjakan']) }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ request('status') === 'sedang_dikerjakan' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Sedang Dikerjakan
            </a>
            <a href="{{ route('tindakans.index', ['status' => 'selesai']) }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ request('status') === 'selesai' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai
            </a>
        </div>
    </div>

    <!-- List of Tindakans -->
    <div class="space-y-4">
        @forelse($tindakans as $t)
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold bg-slate-900 text-white">
                                {{ $t->petak->kode_petak }}
                            </span>
                            <span class="text-xs font-bold text-slate-800">{{ $t->petak->nama_petak }}</span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="text-xs text-slate-500">Tiket: <a href="{{ route('diagnosa.show', $t->diagnosa_id) }}" class="text-emerald-700 font-mono font-bold hover:underline">{{ $t->diagnosa->kode_diagnosa }}</a></span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="text-xs text-slate-500">{{ $t->created_at->format('d M Y, H:i') }}</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-800 font-medium">
                            <strong class="text-slate-900 block mb-1">Instruksi Pengawas ({{ $t->pengawas->name }}):</strong>
                            {{ $t->instruksi_tindakan }}
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-600 pt-1">
                            @if($t->rekomendasi_pestisida)
                                <span>Obat: <strong>{{ $t->rekomendasi_pestisida }}</strong></span>
                            @endif
                            @if($t->dosis_aplikasi)
                                <span>&bull;</span>
                                <span>Dosis: <strong>{{ $t->dosis_aplikasi }}</strong></span>
                            @endif
                            <span>&bull;</span>
                            <span>Petugas: <strong>{{ $t->karyawan?->name ?? 'Karyawan Semai' }}</strong></span>
                        </div>

                        @if($t->catatan_pelaksanaan)
                            <div class="mt-2 text-xs text-emerald-800 bg-emerald-50 p-2.5 rounded-xl border border-emerald-100">
                                <strong>Laporan Pelaksanaan:</strong> {{ $t->catatan_pelaksanaan }} ({{ $t->tanggal_pelaksanaan?->format('d M Y') }})
                            </div>
                        @endif
                    </div>

                    <div class="shrink-0 flex flex-col items-end gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $t->status_badge['class'] }}">
                            {{ $t->status_badge['label'] }}
                        </span>

                        <!-- Form Update Status -->
                        @if($t->status !== 'selesai')
                            <form action="{{ route('tindakans.update-status', $t->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="selesai">
                                <input type="text" name="catatan_pelaksanaan" placeholder="Catatan obat/hasil..." required class="text-xs p-1.5 rounded-lg border border-slate-200">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shrink-0 transition">
                                    Selesai Semprot
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center text-slate-400">
                <i data-lucide="shield-check" class="w-12 h-12 mx-auto text-emerald-400 mb-2"></i>
                <p class="text-sm font-semibold text-slate-700">Semua instruksi tindakan telah selesai ditangani.</p>
            </div>
        @endforelse
    </div>

    @if($tindakans->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200/80">
            {{ $tindakans->links() }}
        </div>
    @endif

</div>
@endsection

