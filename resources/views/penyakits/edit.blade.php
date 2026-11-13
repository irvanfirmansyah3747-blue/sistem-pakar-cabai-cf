@extends('layouts.app')

@section('title', 'Edit Penyakit ' . $penyakit->nama_penyakit)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('penyakits.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Katalog Penyakit</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Edit Penyakit: {{ $penyakit->kode_penyakit }}</h1>
        <p class="text-xs text-slate-500 mb-6">Perbarui deskripsi patogen dan panduan SOP solusi.</p>

        <form action="{{ route('penyakits.update', $penyakit->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Penyakit</label>
                    <input type="text" name="kode_penyakit" required value="{{ old('kode_penyakit', $penyakit->kode_penyakit) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Penyakit</label>
                    <input type="text" name="nama_penyakit" required value="{{ old('nama_penyakit', $penyakit->nama_penyakit) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Latin (Binomial)</label>
                    <input type="text" name="nama_latin" value="{{ old('nama_latin', $penyakit->nama_latin) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 italic focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Penyebab / Patogen</label>
                    <input type="text" name="penyebab" value="{{ old('penyebab', $penyakit->penyebab) }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Lengkap Penyakit</label>
                <textarea name="deskripsi" rows="3" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('deskripsi', $penyakit->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Faktor Pemicu (Kondisi Cuaca / Media)</label>
                <input type="text" name="faktor_pemicu" value="{{ old('faktor_pemicu', $penyakit->faktor_pemicu) }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">SOP Solusi Penanganan (Kuratif)</label>
                <textarea name="solusi_penanganan" rows="4" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('solusi_penanganan', $penyakit->solusi_penanganan) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan Pencegahan (Preventif)</label>
                <textarea name="tindakan_pencegahan" rows="3" class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('tindakan_pencegahan', $penyakit->tindakan_pencegahan) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Ilustrasi Penyakit (Opsional, Max 2MB)</label>
                @if($penyakit->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $penyakit->gambar) }}" alt="{{ $penyakit->nama_penyakit }}" class="h-24 rounded-xl border border-slate-200 object-cover">
                    </div>
                @endif
                <input type="file" name="gambar" accept="image/*"
                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1.5">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                <button type="button" onclick="if(confirm('Hapus penyakit ini beserta seluruh aturan terkait?')) document.getElementById('deletePenyakitForm').submit();" class="text-rose-600 text-xs font-bold hover:underline">
                    Hapus Penyakit
                </button>
                <div class="flex gap-2">
                    <a href="{{ route('penyakits.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        <form id="deletePenyakitForm" action="{{ route('penyakits.destroy', $penyakit->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

