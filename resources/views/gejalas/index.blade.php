@extends('layouts.app')

@section('title', 'Data Gejala Penyakit Cabai')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="activity" class="w-6 h-6 text-emerald-600"></i>
                Data Gejala Penyakit Bibit Cabai
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Daftar indikator gejala klinis bibit cabai di Rumah Semai Helly Seedling.
            </p>
        </div>

        <div>
            <a href="{{ route('gejalas.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Gejala Baru</span>
            </a>
        </div>
    </div>

    <!-- Gejala Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4 w-20">Kode</th>
                        <th class="py-3.5 px-4 w-32">Kategori</th>
                        <th class="py-3.5 px-4">Nama & Ciri Gejala</th>
                        <th class="py-3.5 px-4">Pertanyaan Diagnosa Lapangan</th>
                        <th class="py-3.5 px-4 text-center">Aturan Terkait</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($gejalas as $g)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-700">
                                {{ $g->kode_gejala }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full font-semibold border {{ $g->kategori_badge['class'] }}">
                                    {{ $g->kategori_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-bold text-slate-900 block">{{ $g->nama_gejala }}</span>
                                @if($g->deskripsi)
                                    <span class="text-[11px] text-slate-500">{{ $g->deskripsi }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-600 italic">
                                "{{ $g->pertanyaan_diagnosa ?? '-' }}"
                            </td>
                            <td class="py-3 px-4 text-center font-bold text-slate-700">
                                {{ $g->rules_count }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('gejalas.edit', $g->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('gejalas.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus gejala ini? Aturan terkait akan terhapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
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

