@extends('layouts.app')

@section('title', 'Katalog Penyakit Bibit Cabai')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="book-open" class="w-6 h-6 text-emerald-600"></i>
                Katalog & Ensiklopedia Penyakit Bibit Cabai
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Basis pengetahuan penyakit bibit cabai di Rumah Semai Helly Seedling, Desa Srisawahan, Lampung Tengah.
            </p>
        </div>

        @if(auth()->user()->isPengawas())
            <div>
                <a href="{{ route('penyakits.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Penyakit Baru</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Cards Grid of Penyakits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($penyakits as $p)
            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-xl text-xs font-mono font-bold bg-emerald-950 text-emerald-300">
                            {{ $p->kode_penyakit }}
                        </span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $p->rules_count }} Aturan Gejala
                        </span>
                    </div>

                    <h3 class="font-bold text-base text-slate-900">
                        {{ $p->nama_penyakit }}
                    </h3>
                    @if($p->nama_latin)
                        <p class="text-xs text-emerald-700 italic font-medium mt-0.5">({{ $p->nama_latin }})</p>
                    @endif

                    <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs space-y-1.5 text-slate-600">
                        <p><strong>Penyebab:</strong> {{ $p->penyebab ?? 'Patogen Tanaman' }}</p>
                        <p class="line-clamp-2 text-slate-500">{{ $p->deskripsi }}</p>
                    </div>

                    <div class="mt-3 text-xs text-slate-700 bg-emerald-50/50 p-2.5 rounded-xl border border-emerald-100">
                        <strong class="text-emerald-950 block mb-0.5 flex items-center gap-1">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-emerald-600"></i> Rekomendasi Solusi Singkat:
                        </strong>
                        <p class="line-clamp-2 text-slate-600">{{ $p->solusi_penanganan }}</p>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('penyakits.show', $p->id) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                        <span>Lihat Solusi Lengkap</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>

                    @if(auth()->user()->isPengawas())
                        <div class="flex items-center gap-1">
                            <a href="{{ route('penyakits.edit', $p->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50" title="Edit">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

