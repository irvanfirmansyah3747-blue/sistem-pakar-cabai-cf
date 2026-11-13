@extends('layouts.app')

@section('title', 'Basis Aturan & Bobot CF Pakar')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editRule: {} }">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="sliders" class="w-6 h-6 text-emerald-600"></i>
                Basis Aturan Pengetahuan & Bobot Pakar (CF)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Konfigurasi bobot Certainty Factor ($CF_{pakar} = MB - MD$) dari Pakar Tanaman (Bpk. Ino & Helly Sumanto).
            </p>
        </div>

        <div>
            <button type="button" @click="addModalOpen = true" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Aturan Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('rules.index') }}" method="GET" class="w-full sm:w-auto flex items-center gap-3">
            <label class="text-xs font-semibold text-slate-600 shrink-0">Filter Penyakit:</label>
            <select name="penyakit_id" onchange="this.form.submit()" class="text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">-- Tampilkan Semua Penyakit --</option>
                @foreach($penyakits as $p)
                    <option value="{{ $p->id }}" {{ $penyakitFilter == $p->id ? 'selected' : '' }}>
                        {{ $p->kode_penyakit }} - {{ $p->nama_penyakit }}
                    </option>
                @endforeach
            </select>
        </form>

        <span class="text-xs text-slate-500">
            Total Aturan Aktif: <strong>{{ $rules->total() }}</strong> rules
        </span>
    </div>

    <!-- Rules Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4 w-12">No</th>
                        <th class="py-3.5 px-4">Penyakit Tanaman Cabai</th>
                        <th class="py-3.5 px-4">Gejala Klinis Terkait</th>
                        <th class="py-3.5 px-4 text-center">Bobot Pakar ($CF_{pakar}$)</th>
                        <th class="py-3.5 px-4 text-center">Tingkat Determinasi</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rules as $index => $r)
                        @php
                            $bobot = (float)$r->bobot_pakar;
                            $detLevel = match(true) {
                                $bobot >= 0.90 => ['label' => 'Gejala Kunci / Patognomonik', 'class' => 'bg-emerald-100 text-emerald-800'],
                                $bobot >= 0.80 => ['label' => 'Kuat / Sering Terjadi', 'class' => 'bg-teal-100 text-teal-800'],
                                $bobot >= 0.60 => ['label' => 'Sedang / Karakteristik Umum', 'class' => 'bg-amber-100 text-amber-800'],
                                default => ['label' => 'Gejala Pendukung / Lemah', 'class' => 'bg-slate-100 text-slate-700'],
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 text-slate-400 font-mono">
                                {{ $rules->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white text-[11px] mr-1.5">
                                    {{ $r->penyakit->kode_penyakit }}
                                </span>
                                <span class="font-bold text-slate-900">{{ $r->penyakit->nama_penyakit }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono font-bold px-1.5 py-0.5 rounded bg-emerald-700 text-white text-[11px] mr-1.5">
                                    {{ $r->gejala->kode_gejala }}
                                </span>
                                <span class="text-slate-800 font-medium">{{ $r->gejala->nama_gejala }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="font-mono text-sm font-black text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200">
                                    {{ number_format($r->bobot_pakar, 2) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $detLevel['class'] }}">
                                    {{ $detLevel['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" @click="editRule = { id: {{ $r->id }}, penyakit: '{{ $r->penyakit->nama_penyakit }}', gejala: '{{ $r->gejala->nama_gejala }}', bobot: '{{ $r->bobot_pakar }}' }; editModalOpen = true"
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50" title="Ubah Bobot">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('rules.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini dari basis pengetahuan?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">Belum ada aturan yang cocok dengan filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rules->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $rules->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL: Tambah Aturan Baru -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-4" @click.outside="addModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-base">Tambah Aturan Relasi Baru</h3>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('rules.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Penyakit Cabai</label>
                    <select name="penyakit_id" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Penyakit --</option>
                        @foreach($penyakits as $p)
                            <option value="{{ $p->id }}">{{ $p->kode_penyakit }} - {{ $p->nama_penyakit }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Gejala Klinis</label>
                    <select name="gejala_id" required class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Gejala --</option>
                        @foreach($gejalas as $g)
                            <option value="{{ $g->id }}">{{ $g->kode_gejala }} - {{ $g->nama_gejala }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Bobot Kepastian Pakar ($CF_{pakar} = MB - MD$)
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" step="0.05" min="0.05" max="1.00" name="bobot_pakar" value="0.80" required
                               class="w-32 text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500">
                        <span class="text-xs text-slate-500">Skala rentang: <strong>0.05 s/d 1.00</strong></span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                        Simpan Aturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Bobot Aturan -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-4" @click.outside="editModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-base">Ubah Bobot Certainty Factor</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'/rules/' + editRule.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <span class="text-slate-400 text-xs block">Penyakit:</span>
                    <p class="font-bold text-xs text-slate-800" x-text="editRule.penyakit"></p>
                </div>

                <div>
                    <span class="text-slate-400 text-xs block">Gejala:</span>
                    <p class="font-bold text-xs text-slate-800" x-text="editRule.gejala"></p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Bobot Pakar Baru</label>
                    <input type="number" step="0.05" min="0.05" max="1.00" name="bobot_pakar" :value="editRule.bobot" required
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                        Perbarui Bobot
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

