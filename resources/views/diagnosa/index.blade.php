@extends('layouts.app')

@section('title', 'Riwayat Diagnosa Penyakit Cabai')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-6 h-6 text-emerald-600"></i>
                Riwayat Diagnosa Penyakit Cabai
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                {{ auth()->user()->isPengawas() ? 'Semua catatan hasil diagnosa bibit tanaman cabai yang dihimpun secara digital.' : 'Catatan hasil diagnosa mandiri yang Anda lakukan di lapangan.' }}
            </p>
        </div>

        <div>
            <a href="{{ route('diagnosa.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Diagnosa Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm">
        <form action="{{ route('diagnosa.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Filter Petak Semai</label>
                <select name="petak_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Semua Petak Semai --</option>
                    @foreach($petaks as $p)
                        <option value="{{ $p->id }}" {{ request('petak_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->kode_petak }} - {{ $p->nama_petak }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Penanganan</label>
                <select name="status" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Tindakan</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Terapkan Filter</span>
                </button>
                <a href="{{ route('diagnosa.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table of Diagnosa -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4">Kode Tiket</th>
                        <th class="py-3.5 px-4">Tanggal & Waktu</th>
                        <th class="py-3.5 px-4">Lokasi Petak</th>
                        <th class="py-3.5 px-4">Karyawan</th>
                        <th class="py-3.5 px-4">Penyakit Teridentifikasi</th>
                        <th class="py-3.5 px-4 text-center">Tingkat CF</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($diagnosas as $d)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-700">
                                {{ $d->kode_diagnosa }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 whitespace-nowrap">
                                {{ $d->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $d->petak->kode_petak }}
                                <span class="block text-[11px] font-normal text-slate-500">{{ $d->petak->nama_petak }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-700 font-medium">
                                {{ $d->user->name }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-bold text-slate-900 block">{{ $d->penyakitTerpilih?->nama_penyakit ?? 'Tidak Teridentifikasi' }}</span>
                                <span class="text-[11px] text-slate-400 italic">{{ $d->penyakitTerpilih?->nama_latin }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-bold text-xs {{ $d->persentase_cf >= 80 ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $d->persentase_cf }}%
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold border {{ $d->status_badge['class'] }}">
                                    {{ $d->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('diagnosa.show', $d->id) }}" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold transition flex items-center gap-1">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        <span>Rincian</span>
                                    </a>

                                    @if(auth()->user()->isPengawas())
                                        <form action="{{ route('diagnosa.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat diagnosa ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i data-lucide="clipboard-x" class="w-12 h-12 mx-auto text-slate-300 mb-2"></i>
                                <p class="text-sm">Tidak ada riwayat diagnosa yang sesuai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($diagnosas->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $diagnosas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

