@extends('layouts.app')

@section('title', 'Tambah Petak Semai Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('petaks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Peta Petak</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Tambah Petak / Bedengan Semai Baru</h1>
        <p class="text-xs text-slate-500 mb-6">Daftarkan petak baru di lingkungan Rumah Semai Helly Seedling.</p>

        <form action="{{ route('petaks.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Petak</label>
                    <input type="text" name="kode_petak" required placeholder="PTK-D01" value="{{ old('kode_petak') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Blok</label>
                    <input type="text" name="lokasi_blok" required placeholder="Greenhouse 1 / Blok Barat" value="{{ old('lokasi_blok') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Petak / Bedengan</label>
                <input type="text" name="nama_petak" required placeholder="Bedengan D1 - Cabai Rawit Merah" value="{{ old('nama_petak') }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Varietas Cabai</label>
                    <input type="text" name="jenis_cabai" required placeholder="Cabai Rawit Merah (Ori 212)" value="{{ old('jenis_cabai') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Kesehatan Awal</label>
                    <select name="status_kesehatan" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="sehat">Sehat</option>
                        <option value="waspada">Waspada</option>
                        <option value="terinfeksi">Terinfeksi</option>
                        <option value="kosong">Kosong / Sterilisasi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kapasitas Bibit</label>
                    <input type="number" name="kapasitas_bibit" required min="0" value="{{ old('kapasitas_bibit', 5000) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Bibit Aktif Sekarang</label>
                    <input type="number" name="jumlah_bibit_aktif" required min="0" value="{{ old('jumlah_bibit_aktif', 5000) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Semai</label>
                    <input type="date" name="tanggal_semai" required value="{{ old('tanggal_semai', date('Y-m-d')) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                <textarea name="catatan" rows="3" placeholder="Informasi media tanah, jadwal penyiraman, atau perlakuan pupuk..."
                          class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('catatan') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('petaks.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Simpan Petak Baru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

