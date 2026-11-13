@extends('layouts.app')

@section('title', 'Detail Petak ' . $petak->kode_petak)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action -->
    <div class="flex items-center justify-between">
        <a href="{{ route('petaks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Peta Petak</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('diagnosa.create', ['petak_id' => $petak->id]) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Diagnosa Petak Ini</span>
            </a>
            @if(auth()->user()->isPengawas())
                @if(in_array($petak->status_kesehatan, ['waspada', 'terinfeksi']))
                    <form action="{{ route('petaks.verifikasi-sehat', $petak->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Verifikasi Petak Sehat</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('petaks.edit', $petak->id) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                    Edit Petak
                </a>
            @endif
        </div>
    </div>

    <!-- Petak Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-xl text-xs font-mono font-bold bg-slate-900 text-white">
                        {{ $petak->kode_petak }}
                    </span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $petak->status_badge['bg'] }}">
                        {{ $petak->status_badge['label'] }}
                    </span>
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ $petak->nama_petak }}</h1>
                <p class="text-xs sm:text-sm text-emerald-700 font-semibold mt-1 flex items-center gap-1.5">
                    <i data-lucide="sprout" class="w-4 h-4"></i>
                    Varietas: {{ $petak->jenis_cabai }}
                </p>
            </div>

            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs space-y-1 sm:text-right">
                <span class="text-slate-400 block">Kapasitas & Populasi:</span>
                <span class="text-lg font-black text-slate-900 block">{{ number_format($petak->jumlah_bibit_aktif) }} / {{ number_format($petak->kapasitas_bibit) }} bibit</span>
                <span class="text-[11px] text-slate-500">Semai: {{ $petak->tanggal_semai?->format('d M Y') }}</span>
            </div>
        </div>

        @if($petak->catatan)
            <div class="mt-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-600">
                <strong>Catatan Petak:</strong> {{ $petak->catatan }}
            </div>
        @endif
    </div>

    <!-- Riwayat Kasus Diagnosa Petak Ini -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-emerald-600"></i>
            Riwayat Diagnosa pada {{ $petak->kode_petak }}
        </h3>

        <div class="space-y-3">
            @forelse($diagnosas as $d)
                <div class="p-3.5 rounded-2xl border border-slate-200/80 hover:bg-slate-50/70 transition flex items-center justify-between text-xs">
                    <div>
                        <span class="font-mono font-bold text-emerald-700">{{ $d->kode_diagnosa }}</span>
                        <span class="text-slate-400 mx-2">&bull;</span>
                        <span class="font-bold text-slate-800">{{ $d->penyakitTerpilih?->nama_penyakit ?? 'Tidak Teridentifikasi' }}</span>
                        <span class="text-slate-400 mx-2">&bull;</span>
                        <span class="font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $d->persentase_cf }}% CF</span>
                    </div>
                    <a href="{{ route('diagnosa.show', $d->id) }}" class="text-emerald-700 font-bold hover:underline">
                        Lihat Hasil &rarr;
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada riwayat penyakit tercatat pada petak ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

