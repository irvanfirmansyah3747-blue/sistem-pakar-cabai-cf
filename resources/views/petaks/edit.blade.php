@extends('layouts.app')

@section('title', 'Edit Petak ' . $petak->kode_petak)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('petaks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Peta Petak</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Edit Petak Semai: {{ $petak->kode_petak }}</h1>
        <p class="text-xs text-slate-500 mb-6">Perbarui informasi populasi dan status kesehatan bedengan.</p>

        <form action="{{ route('petaks.update', $petak->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Petak</label>
                    <input type="text" name="kode_petak" required value="{{ old('kode_petak', $petak->kode_petak) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Blok</label>
                    <input type="text" name="lokasi_blok" required value="{{ old('lokasi_blok', $petak->lokasi_blok) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Petak / Bedengan</label>
                <input type="text" name="nama_petak" required value="{{ old('nama_petak', $petak->nama_petak) }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Varietas Cabai</label>
                    <input type="text" name="jenis_cabai" required value="{{ old('jenis_cabai', $petak->jenis_cabai) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Kesehatan</label>
                    <select name="status_kesehatan" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="sehat" {{ old('status_kesehatan', $petak->status_kesehatan) === 'sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="waspada" {{ old('status_kesehatan', $petak->status_kesehatan) === 'waspada' ? 'selected' : '' }}>Waspada</option>
                        <option value="terinfeksi" {{ old('status_kesehatan', $petak->status_kesehatan) === 'terinfeksi' ? 'selected' : '' }}>Terinfeksi</option>
                        <option value="kosong" {{ old('status_kesehatan', $petak->status_kesehatan) === 'kosong' ? 'selected' : '' }}>Kosong / Sterilisasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kapasitas Bibit</label>
                    <input type="number" name="kapasitas_bibit" required min="0" value="{{ old('kapasitas_bibit', $petak->kapasitas_bibit) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Bibit Aktif</label>
                    <input type="number" name="jumlah_bibit_aktif" required min="0" value="{{ old('jumlah_bibit_aktif', $petak->jumlah_bibit_aktif) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Semai</label>
                    <input type="date" name="tanggal_semai" required value="{{ old('tanggal_semai', $petak->tanggal_semai?->toDateString()) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                <textarea name="catatan" rows="3" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('catatan', $petak->catatan) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                <button type="button" onclick="if(confirm('Hapus petak ini beserta riwayatnya?')) document.getElementById('deletePetakForm').submit();" class="text-rose-600 text-xs font-bold hover:underline">
                    Hapus Petak
                </button>
                <div class="flex gap-2">
                    <a href="{{ route('petaks.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        <form id="deletePetakForm" action="{{ route('petaks.destroy', $petak->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

