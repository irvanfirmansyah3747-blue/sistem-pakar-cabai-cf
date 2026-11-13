@extends('layouts.app')

@section('title', 'Tambah Penyakit Cabai')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('penyakits.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Katalog Penyakit</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Tambah Master Penyakit Bibit Cabai</h1>
        <p class="text-xs text-slate-500 mb-6">Tambahkan jenis penyakit baru ke dalam basis pengetahuan sistem pakar.</p>

        <form action="{{ route('penyakits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Penyakit</label>
                    <input type="text" name="kode_penyakit" required placeholder="P07" value="{{ old('kode_penyakit') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Penyakit</label>
                    <input type="text" name="nama_penyakit" required placeholder="Penyakit Hawar Daun / Phytophthora" value="{{ old('nama_penyakit') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Latin (Binomial)</label>
                    <input type="text" name="nama_latin" placeholder="Phytophthora capsici" value="{{ old('nama_latin') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 italic focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Penyebab / Patogen</label>
                    <input type="text" name="penyebab" placeholder="Oomycetes / Jamur air" value="{{ old('penyebab') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Lengkap Penyakit</label>
                <textarea name="deskripsi" rows="3" required placeholder="Jelaskan karakteristik serangan pada bibit cabai..."
                          class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Faktor Pemicu (Kondisi Cuaca / Media)</label>
                <input type="text" name="faktor_pemicu" placeholder="Kelembapan di atas 90%, tanah tergenang, drainase buruk..." value="{{ old('faktor_pemicu') }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">SOP Solusi Penanganan (Kuratif)</label>
                <textarea name="solusi_penanganan" rows="4" required placeholder="1. Cabut bibit sakit...&#10;2. Semprot fungisida dosis..."
                          class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('solusi_penanganan') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan Pencegahan (Preventif)</label>
                <textarea name="tindakan_pencegahan" rows="3" placeholder="Sanitasi media semai, pengaturan jarak nampan bibit..."
                          class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('tindakan_pencegahan') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Ilustrasi Penyakit (Opsional, Max 2MB)</label>
                <input type="file" name="gambar" accept="image/*"
                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1.5">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('penyakits.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Simpan Penyakit
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

