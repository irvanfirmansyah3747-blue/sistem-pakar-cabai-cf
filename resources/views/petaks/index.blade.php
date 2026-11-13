@extends('layouts.app')

@section('title', 'Peta & Lokasi Petak Semai')

@section('content')
<div class="space-y-6" x-data="{ viewMode: 'grid' }">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="grid-3x3" class="w-6 h-6 text-emerald-600"></i>
                Peta & Lokasi Petak Semai (Helly Seedling)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Monitoring sebaran bibit, kapasitas bedengan, dan status kesehatan di seluruh blok greenhouse.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <!-- View Mode Switcher -->
            <div class="bg-slate-100 p-1 rounded-xl flex items-center text-xs font-semibold">
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'" class="px-2.5 py-1.5 rounded-lg flex items-center gap-1 transition">
                    <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
                    <span>Grid Visual</span>
                </button>
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900'" class="px-2.5 py-1.5 rounded-lg flex items-center gap-1 transition">
                    <i data-lucide="list" class="w-3.5 h-3.5"></i>
                    <span>Tabel</span>
                </button>
            </div>

            @if(auth()->user()->isPengawas())
                <a href="{{ route('petaks.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Petak Baru</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Grid View Mode -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($petaks as $petak)
            @php
                $badge = $petak->status_badge;
                $borderBg = match($petak->status_kesehatan) {
                    'sehat' => 'border-emerald-200 bg-white hover:border-emerald-400',
                    'waspada' => 'border-amber-200 bg-amber-50/20 hover:border-amber-400',
                    'terinfeksi' => 'border-rose-200 bg-rose-50/20 hover:border-rose-400',
                    default => 'border-slate-200 bg-slate-50/50 hover:border-slate-300'
                };
            @endphp
            <div class="rounded-3xl border {{ $borderBg }} p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-xl text-xs font-mono font-bold bg-slate-900 text-white">
                            {{ $petak->kode_petak }}
                        </span>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $badge['bg'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <h3 class="font-bold text-base text-slate-900">
                        {{ $petak->nama_petak }}
                    </h3>
                    <p class="text-xs text-emerald-700 font-semibold mt-0.5 flex items-center gap-1">
                        <i data-lucide="leaf" class="w-3.5 h-3.5"></i>
                        {{ $petak->jenis_cabai }}
                    </p>

                    <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs space-y-1.5 text-slate-600">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Lokasi Blok:</span>
                            <span class="font-medium text-slate-800">{{ $petak->lokasi_blok }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Populasi Bibit:</span>
                            <span class="font-bold text-slate-900">{{ number_format($petak->jumlah_bibit_aktif) }} / {{ number_format($petak->kapasitas_bibit) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tgl Semai:</span>
                            <span>{{ $petak->tanggal_semai?->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Kasus Diagnosa:</span>
                            <span class="font-semibold text-emerald-700">{{ $petak->diagnosas_count }} riwayat</span>
                        </div>
                    </div>

                    @if($petak->catatan)
                        <p class="text-[11px] text-slate-500 mt-2.5 italic line-clamp-2">"{{ $petak->catatan }}"</p>
                    @endif
                </div>

                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('diagnosa.create', ['petak_id' => $petak->id]) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                        <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                        <span>Diagnosa Petak</span>
                    </a>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('petaks.show', $petak->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition" title="Detail Petak">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        @if(auth()->user()->isPengawas())
                            <a href="{{ route('petaks.edit', $petak->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Table View Mode -->
    <div x-show="viewMode === 'table'" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden" x-cloak>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3 px-4">Kode</th>
                        <th class="py-3 px-4">Nama Bedengan</th>
                        <th class="py-3 px-4">Lokasi Blok</th>
                        <th class="py-3 px-4">Varietas Cabai</th>
                        <th class="py-3 px-4 text-center">Bibit Aktif</th>
                        <th class="py-3 px-4">Status Kesehatan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($petaks as $p)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-700">{{ $p->kode_petak }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $p->nama_petak }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $p->lokasi_blok }}</td>
                            <td class="py-3 px-4 text-emerald-700 font-medium">{{ $p->jenis_cabai }}</td>
                            <td class="py-3 px-4 text-center font-semibold">{{ number_format($p->jumlah_bibit_aktif) }} / {{ number_format($p->kapasitas_bibit) }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full font-semibold border {{ $p->status_badge['bg'] }}">
                                    {{ $p->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('petaks.show', $p->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold transition">
                                        Detail
                                    </a>
                                    @if(auth()->user()->isPengawas())
                                        <a href="{{ route('petaks.edit', $p->id) }}" class="p-1 rounded-lg text-slate-500 hover:text-amber-600">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

