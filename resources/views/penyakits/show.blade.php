@extends('layouts.app')

@section('title', 'Detail Penyakit ' . $penyakit->nama_penyakit)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('penyakits.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Katalog Penyakit</span>
        </a>

        @if(auth()->user()->isPengawas())
            <a href="{{ route('penyakits.edit', $penyakit->id) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold">
                Edit Penyakit
            </a>
        @endif
    </div>

    <!-- Disease Header Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-2.5 py-1 rounded-xl text-xs font-mono font-bold bg-emerald-950 text-emerald-300">
                {{ $penyakit->kode_penyakit }}
            </span>
            <span class="text-xs text-slate-500 font-medium">Patogen: {{ $penyakit->penyebab ?? 'Cendawan / Bakteri' }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $penyakit->nama_penyakit }}</h1>
        @if($penyakit->nama_latin)
            <p class="text-sm text-emerald-700 font-medium italic mt-0.5">({{ $penyakit->nama_latin }})</p>
        @endif

        <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-700 leading-relaxed">
            <strong class="text-slate-900 block mb-1">Deskripsi Penyakit:</strong>
            {{ $penyakit->deskripsi }}
        </div>
    </div>

    <!-- SOP Solusi & Pencegahan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white rounded-3xl border border-emerald-200 p-6 shadow-sm space-y-3 bg-emerald-50/20">
            <h3 class="font-bold text-sm text-emerald-950 flex items-center gap-2">
                <i data-lucide="shield-alert" class="w-4 h-4 text-emerald-600"></i>
                SOP Solusi Penanganan Lapangan
            </h3>
            <div class="text-xs text-slate-700 space-y-2 whitespace-pre-line leading-relaxed">
                {{ $penyakit->solusi_penanganan }}
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-teal-200 p-6 shadow-sm space-y-3 bg-teal-50/20">
            <h3 class="font-bold text-sm text-teal-950 flex items-center gap-2">
                <i data-lucide="shield-check" class="w-4 h-4 text-teal-600"></i>
                Langkah Pencegahan (Preventif)
            </h3>
            <div class="text-xs text-slate-700 space-y-2 whitespace-pre-line leading-relaxed">
                {{ $penyakit->tindakan_pencegahan ?? 'Gunakan benih bersertifikat dan sanitasi media tanah secara berkala.' }}
            </div>
            @if($penyakit->faktor_pemicu)
                <div class="mt-4 pt-3 border-t border-teal-200/60 text-xs text-teal-900">
                    <strong>Faktor Pemicu:</strong> {{ $penyakit->faktor_pemicu }}
                </div>
            @endif
        </div>
    </div>

    <!-- Gejala yang Terkait dengan Penyakit Ini -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            Gejala & Bobot Pakar Terkait (Certainty Factor)
        </h3>

        <div class="space-y-2.5">
            @forelse($penyakit->rules as $rule)
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="font-mono font-bold px-2 py-0.5 rounded bg-slate-800 text-white">
                            {{ $rule->gejala->kode_gejala }}
                        </span>
                        <span class="font-semibold text-slate-800">{{ $rule->gejala->nama_gejala }}</span>
                    </div>
                    <span class="font-mono font-bold px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 shrink-0">
                        Bobot CF Pakar: {{ $rule->bobot_pakar }}
                    </span>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada aturan gejala yang dikaitkan ke penyakit ini.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

