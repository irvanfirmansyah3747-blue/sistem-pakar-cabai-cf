@extends('layouts.app')

@section('title', 'Buat Instruksi Penanganan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('diagnosa.show', $diagnosa->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Hasil Diagnosa</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="mb-6">
            <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold bg-slate-900 text-white">
                {{ $diagnosa->kode_diagnosa }}
            </span>
            <h1 class="text-xl font-bold text-slate-900 mt-2">Buat Instruksi Tindakan Penanganan</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Terbitkan arahan teknis penyemprotan obat/fungisida untuk <strong>{{ $diagnosa->petak->kode_petak }} - {{ $diagnosa->petak->nama_petak }}</strong>.
            </p>
        </div>

        <form action="{{ route('tindakans.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="diagnosa_id" value="{{ $diagnosa->id }}">

            <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-200 text-xs">
                <p class="text-slate-600">Hasil Diagnosa Utama:</p>
                <p class="font-bold text-emerald-950 text-sm mt-0.5">
                    {{ $diagnosa->penyakitTerpilih?->nama_penyakit ?? 'Belum Teridentifikasi' }} ({{ $diagnosa->persentase_cf }}%)
                </p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tugaskan kepada Karyawan</label>
                <select name="karyawan_id" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @foreach($karyawans as $k)
                        <option value="{{ $k->id }}" {{ $diagnosa->user_id == $k->id ? 'selected' : '' }}>
                            {{ $k->name }} ({{ $k->phone ?? 'Staf Semai' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Instruksi Tindakan Lapangan</label>
                <textarea name="instruksi_tindakan" rows="4" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('instruksi_tindakan', $diagnosa->penyakitTerpilih?->solusi_penanganan) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Rekomendasi Pestisida / Agens Hayati</label>
                    <input type="text" name="rekomendasi_pestisida" value="{{ old('rekomendasi_pestisida') }}" placeholder="Contoh: Propamokarb / Mankozeb"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dosis Aplikasi</label>
                    <input type="text" name="dosis_aplikasi" value="{{ old('dosis_aplikasi') }}" placeholder="Contoh: 1.5 ml / Liter air"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('diagnosa.show', $diagnosa->id) }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Kirim Instruksi Tindakan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

