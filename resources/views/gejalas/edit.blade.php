@extends('layouts.app')

@section('title', 'Edit Gejala ' . $gejala->kode_gejala)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('gejalas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Data Gejala</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Edit Gejala: {{ $gejala->kode_gejala }}</h1>
        <p class="text-xs text-slate-500 mb-6">Perbarui deskripsi nama dan pertanyaan panduan diagnosa.</p>

        <form action="{{ route('gejalas.update', $gejala->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Gejala</label>
                    <input type="text" name="kode_gejala" required value="{{ old('kode_gejala', $gejala->kode_gejala) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Bagian Tanaman</label>
                    <select name="kategori_bagian" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="daun" {{ old('kategori_bagian', $gejala->kategori_bagian) === 'daun' ? 'selected' : '' }}>🍃 Bagian Daun</option>
                        <option value="batang" {{ old('kategori_bagian', $gejala->kategori_bagian) === 'batang' ? 'selected' : '' }}>🪵 Bagian Batang & Pangkal</option>
                        <option value="akar" {{ old('kategori_bagian', $gejala->kategori_bagian) === 'akar' ? 'selected' : '' }}>🌱 Bagian Perakaran</option>
                        <option value="bibit_umum" {{ old('kategori_bagian', $gejala->kategori_bagian) === 'bibit_umum' ? 'selected' : '' }}>🌾 Kondisi Bibit Keseluruhan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Gejala Klinis</label>
                <input type="text" name="nama_gejala" required value="{{ old('nama_gejala', $gejala->nama_gejala) }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pertanyaan Diagnosa Lapangan</label>
                <input type="text" name="pertanyaan_diagnosa" value="{{ old('pertanyaan_diagnosa', $gejala->pertanyaan_diagnosa) }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Detail Visual</label>
                <textarea name="deskripsi" rows="3" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('deskripsi', $gejala->deskripsi) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('gejalas.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

