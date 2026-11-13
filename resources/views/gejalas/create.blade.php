@extends('layouts.app')

@section('title', 'Tambah Gejala Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('gejalas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Data Gejala</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Tambah Master Gejala Klinis</h1>
        <p class="text-xs text-slate-500 mb-6">Daftarkan ciri fisik dan keluhan gejala baru pada bibit cabai.</p>

        <form action="{{ route('gejalas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Gejala</label>
                    <input type="text" name="kode_gejala" required placeholder="G16" value="{{ old('kode_gejala') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Bagian Tanaman</label>
                    <select name="kategori_bagian" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="daun">🍃 Bagian Daun</option>
                        <option value="batang">🪵 Bagian Batang & Pangkal</option>
                        <option value="akar">🌱 Bagian Perakaran</option>
                        <option value="bibit_umum">🌾 Kondisi Bibit Keseluruhan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Gejala Klinis</label>
                <input type="text" name="nama_gejala" required placeholder="Batang berlendir hitam dan mengeluarkan bau masam" value="{{ old('nama_gejala') }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pertanyaan Diagnosa Lapangan (Untuk Panduan Karyawan)</label>
                <input type="text" name="pertanyaan_diagnosa" placeholder="Apakah batang bibit tampak basah berlendir hitam?" value="{{ old('pertanyaan_diagnosa') }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Detail Visual</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan penampakan mikroskopis/kasat mata..."
                          class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('gejalas.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Simpan Gejala Baru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

