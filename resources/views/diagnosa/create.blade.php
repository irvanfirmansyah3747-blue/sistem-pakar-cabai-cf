@extends('layouts.app')

@section('title', 'Form Konsultasi Diagnosa Gejala')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="diagnosaForm()">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-2">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-emerald-600"></i> Wizard Konsultasi Cerdas
                </span>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Diagnosa Gejala Penyakit Bibit Cabai
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
                    Pilih lokasi petak semai dan tandai tingkat keyakinan Anda terhadap gejala yang tampak pada bibit cabai di lapangan. Mesin Certainty Factor akan menghitung probabilitas penyakit secara presisi.
                </p>
            </div>
            <div class="flex items-center gap-2 bg-slate-50 p-3 rounded-2xl border border-slate-200 text-xs">
                <i data-lucide="help-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <span class="text-slate-600">Skala: <strong>Sangat Yakin (1.0)</strong> hingga <strong>Ragu (0.4)</strong></span>
            </div>
        </div>
    </div>

    <!-- Main Diagnosis Form -->
    <form action="{{ route('diagnosa.store') }}" method="POST" enctype="multipart/form-data" id="formDiagnosa" class="space-y-6">
        @csrf

        <!-- LANGKAH 1: Pilih Petak Semai -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow">
                    1
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Pilih Lokasi Petak Semai (Plot)</h3>
                    <p class="text-xs text-slate-500">Tentukan bedengan persemaian tempat sampel bibit diperiksa.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 mt-5">
                @foreach($petaks as $petak)
                    <label class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition-all duration-200"
                           :class="selectedPetak == '{{ $petak->id }}' ? 'border-emerald-600 bg-emerald-50/50 ring-2 ring-emerald-500/20 shadow-sm' : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50/50'">
                        <input type="radio" name="petak_id" value="{{ $petak->id }}" 
                               x-model="selectedPetak" required class="sr-only">
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono text-xs font-bold px-2 py-0.5 rounded bg-slate-900 text-white">
                                {{ $petak->kode_petak }}
                            </span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $petak->status_badge['bg'] }}">
                                {{ $petak->status_badge['label'] }}
                            </span>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900">{{ $petak->nama_petak }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $petak->jenis_cabai }} ({{ $petak->lokasi_blok }})</p>
                        
                        <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Bibit: {{ number_format($petak->jumlah_bibit_aktif) }}</span>
                            <span x-show="selectedPetak == '{{ $petak->id }}'" class="text-emerald-700 font-bold flex items-center gap-0.5" x-cloak>
                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Terpilih
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- LANGKAH 2: Pilih Gejala & Skala Keyakinan User (Certainty Factor) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        2
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Identifikasi Gejala di Lapangan</h3>
                        <p class="text-xs text-slate-500">Tentukan seberapa yakin Anda melihat gejala-gejala berikut pada bibit.</p>
                    </div>
                </div>

                <!-- Live Symptom Counter Badge -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1.5">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span x-text="activeSymptomsCount">0</span> Gejala Dipilih
                    </span>
                </div>
            </div>

            <!-- Filter & Search Bar for Symptoms -->
            <div class="mt-5 flex flex-col sm:flex-row gap-3 items-center justify-between">
                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-1.5 p-1 bg-slate-100 rounded-2xl w-full sm:w-auto text-xs font-semibold text-slate-600">
                    <button type="button" @click="activeTab = 'semua'" 
                            :class="activeTab === 'semua' ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900'"
                            class="px-3 py-1.5 rounded-xl transition">
                        Semua Gejala
                    </button>
                    <button type="button" @click="activeTab = 'daun'" 
                            :class="activeTab === 'daun' ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900'"
                            class="px-3 py-1.5 rounded-xl transition">
                        🍃 Daun
                    </button>
                    <button type="button" @click="activeTab = 'batang'" 
                            :class="activeTab === 'batang' ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900'"
                            class="px-3 py-1.5 rounded-xl transition">
                        🪵 Batang
                    </button>
                    <button type="button" @click="activeTab = 'akar'" 
                            :class="activeTab === 'akar' ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900'"
                            class="px-3 py-1.5 rounded-xl transition">
                        🌱 Akar
                    </button>
                    <button type="button" @click="activeTab = 'bibit_umum'" 
                            :class="activeTab === 'bibit_umum' ? 'bg-white text-slate-900 shadow-sm' : 'hover:text-slate-900'"
                            class="px-3 py-1.5 rounded-xl transition">
                        🌾 Kondisi Umum
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3"></i>
                    <input type="text" x-model="searchQuery" placeholder="Cari kata gejala..."
                           class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50">
                </div>
            </div>

            <!-- List of Symptoms with Interactive Confidence Selector -->
            <div class="mt-5 space-y-3">
                @foreach($gejalas as $gejala)
                    <div x-show="matchesFilter('{{ $gejala->kategori_bagian }}', '{{ strtolower(addslashes($gejala->nama_gejala)) }}')"
                         class="p-4 rounded-2xl border border-slate-200 transition-all duration-150"
                         :class="symptoms['{{ $gejala->id }}'] > 0 ? 'bg-emerald-50/30 border-emerald-300 shadow-sm' : 'bg-white hover:bg-slate-50/60'">
                        
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                            <div class="space-y-1 max-w-xl">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded bg-slate-800 text-white">
                                        {{ $gejala->kode_gejala }}
                                    </span>
                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $gejala->kategori_badge['class'] }}">
                                        {{ $gejala->kategori_badge['label'] }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm">
                                    {{ $gejala->nama_gejala }}
                                </h4>
                                @if($gejala->pertanyaan_diagnosa)
                                    <p class="text-xs text-slate-500 italic">"{{ $gejala->pertanyaan_diagnosa }}"</p>
                                @endif
                            </div>

                            <!-- Interactive Button Group for Certainty Scale -->
                            <div class="shrink-0 flex items-center gap-1 bg-slate-100/80 p-1 rounded-xl border border-slate-200">
                                <button type="button" @click="setSymptomWeight('{{ $gejala->id }}', 0.0)"
                                        :class="symptoms['{{ $gejala->id }}'] == 0.0 ? 'bg-white text-slate-800 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2.5 py-1.5 rounded-lg text-xs transition">
                                    Tidak Ada
                                </button>
                                <button type="button" @click="setSymptomWeight('{{ $gejala->id }}', 0.4)"
                                        :class="symptoms['{{ $gejala->id }}'] == 0.4 ? 'bg-amber-500 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                        class="px-2.5 py-1.5 rounded-lg text-xs transition" title="Sedikit Ragu">
                                    Ragu (0.4)
                                </button>
                                <button type="button" @click="setSymptomWeight('{{ $gejala->id }}', 0.6)"
                                        :class="symptoms['{{ $gejala->id }}'] == 0.6 ? 'bg-teal-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                        class="px-2.5 py-1.5 rounded-lg text-xs transition" title="Cukup Yakin">
                                    Cukup (0.6)
                                </button>
                                <button type="button" @click="setSymptomWeight('{{ $gejala->id }}', 0.8)"
                                        :class="symptoms['{{ $gejala->id }}'] == 0.8 ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                        class="px-2.5 py-1.5 rounded-lg text-xs transition" title="Yakin">
                                    Yakin (0.8)
                                </button>
                                <button type="button" @click="setSymptomWeight('{{ $gejala->id }}', 1.0)"
                                        :class="symptoms['{{ $gejala->id }}'] == 1.0 ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                        class="px-2.5 py-1.5 rounded-lg text-xs transition" title="Sangat Yakin">
                                    Sangat Yakin (1.0)
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Input for Form Submission -->
                        <input type="hidden" :name="'gejalas[' + {{ $gejala->id }} + ']'" :value="symptoms['{{ $gejala->id }}'] || 0.0">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- LANGKAH 3: Catatan Lapangan & Submit -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow">
                    3
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Catatan Tambahan Lapangan</h3>
                    <p class="text-xs text-slate-500">Opsional: Tambahkan catatan kondisi cuaca, umur semai, atau perkiraan jumlah bibit terindikasi.</p>
                </div>
            </div>

            <div class="mt-4 space-y-4">
                <textarea name="catatan_karyawan" rows="3" placeholder="Contoh: Ditemukan sekitar 20 bibit cabai di tray sebelah timur mulai roboh setelah hujan deras kemarin..."
                          class="w-full text-xs sm:text-sm p-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50 placeholder-slate-400"></textarea>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Foto Bukti Kondisi Bibit di Lapangan (Opsional, Max 3MB)
                    </label>
                    <input type="file" name="foto_bukti" accept="image/*"
                           class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-2xl p-1.5 bg-slate-50">
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="text-xs text-slate-500">
                    <span x-text="activeSymptomsCount">0</span> gejala dipilih untuk diproses dengan rumus Certainty Factor.
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="submit" :disabled="activeSymptomsCount === 0 || !selectedPetak"
                            :class="activeSymptomsCount > 0 && selectedPetak ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white shadow-lg shadow-emerald-600/30 cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                            class="px-6 py-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4"></i>
                        <span>Hitung & Analisis Diagnosa CF</span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function diagnosaForm() {
        return {
            selectedPetak: '{{ request()->query('petak_id', $petaks->first()?->id) }}',
            activeTab: 'semua',
            searchQuery: '',
            symptoms: {},

            init() {
                // Initialize default weight 0.0 for all symptoms
                @foreach($gejalas as $gejala)
                    this.symptoms['{{ $gejala->id }}'] = 0.0;
                @endforeach
            },

            setSymptomWeight(id, weight) {
                this.symptoms[id] = weight;
            },

            get activeSymptomsCount() {
                return Object.values(this.symptoms).filter(w => parseFloat(w) > 0).length;
            },

            matchesFilter(kategori, text) {
                const matchTab = (this.activeTab === 'semua' || this.activeTab === kategori);
                const query = this.searchQuery.toLowerCase().trim();
                const matchQuery = !query || text.includes(query);
                return matchTab && matchQuery;
            }
        }
    }
</script>
@endpush

