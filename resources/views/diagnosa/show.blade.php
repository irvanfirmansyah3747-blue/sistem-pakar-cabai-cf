@extends('layouts.app')

@section('title', 'Hasil Diagnosa ' . $diagnosa->kode_diagnosa)

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ mathModalOpen: false, actionModalOpen: false }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('diagnosa.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Riwayat Diagnosa</span>
        </a>

        <div class="flex items-center gap-2">
            <button @click="window.print()" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition flex items-center gap-1.5 shadow-sm">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Cetak Lembar Diagnosa</span>
            </button>

            @if(auth()->user()->isPengawas() && $diagnosa->status_tindakan === 'menunggu')
                <button @click="actionModalOpen = true" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-md shadow-amber-500/20 transition flex items-center gap-1.5">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Instruksi Tindakan</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Main Diagnosis Summary Banner -->
    <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-emerald-900/40">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center relative z-10">
            <!-- Left Info -->
            <div class="md:col-span-8 space-y-3">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-mono font-bold px-2.5 py-0.5 rounded-lg bg-emerald-500 text-slate-950">
                        {{ $diagnosa->kode_diagnosa }}
                    </span>
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-300">{{ $diagnosa->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-300">Pemeriksa: <strong>{{ $diagnosa->user->name }}</strong></span>
                </div>

                <div>
                    <span class="text-xs uppercase tracking-wider text-emerald-400 font-semibold">Hasil Inferensi Certainty Factor:</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white mt-0.5">
                        {{ $diagnosa->penyakitTerpilih?->nama_penyakit ?? 'Tidak Ada Kecocokan Signifikan' }}
                    </h1>
                    @if($diagnosa->penyakitTerpilih?->nama_latin)
                        <p class="text-sm text-emerald-300 italic font-medium">({{ $diagnosa->penyakitTerpilih->nama_latin }})</p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2 pt-2 text-xs">
                    <span class="bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700/80 text-slate-200">
                        Petak: <strong>{{ $diagnosa->petak->kode_petak }}</strong> ({{ $diagnosa->petak->nama_petak }})
                    </span>
                    <span class="bg-slate-800/80 px-3 py-1 rounded-xl border border-slate-700/80 text-slate-200">
                        Varietas: <strong>{{ $diagnosa->petak->jenis_cabai }}</strong>
                    </span>
                </div>
            </div>

            <!-- Right Circular / Percentage Badge -->
            <div class="md:col-span-4 flex flex-col items-center justify-center p-6 bg-slate-950/60 rounded-2xl border border-emerald-500/30 text-center">
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold mb-1">Tingkat Kepastian (CF)</span>
                <div class="text-4xl sm:text-5xl font-black text-emerald-400 font-mono tracking-tight">
                    {{ $diagnosa->persentase_cf }}%
                </div>
                <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $diagnosa->persentase_cf >= 80 ? 'bg-rose-500/20 text-rose-300 border border-rose-500/40' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $diagnosa->persentase_cf >= 80 ? 'bg-rose-400' : 'bg-emerald-400' }}"></span>
                    {{ $diagnosa->tingkat_keyakinan }}
                </div>
                <button @click="mathModalOpen = true" class="mt-4 text-[11px] font-bold text-emerald-400 hover:text-emerald-300 underline flex items-center gap-1">
                    <i data-lucide="code-2" class="w-3.5 h-3.5"></i>
                    <span>Buka Rincian Rumus & Kalkulasi</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Gejala yang Terpilih / Diamati -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <i data-lucide="check-square" class="w-5 h-5 text-emerald-600"></i>
                    Gejala yang Ditemukan di Lapangan (Input Karyawan)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar observasi gejala beserta skala keyakinan pengamat.</p>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ $diagnosa->details->count() }} Gejala Teramati
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
            @foreach($diagnosa->details as $item)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold px-1.5 py-0.5 rounded bg-slate-800 text-white">
                                {{ $item->gejala->kode_gejala }}
                            </span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $item->gejala->kategori_badge['class'] }}">
                                {{ $item->gejala->kategori_badge['label'] }}
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-800">{{ $item->gejala->nama_gejala }}</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-emerald-100 text-emerald-800 shrink-0">
                        {{ $item->keterangan_user }}
                    </span>
                </div>
            @endforeach
        </div>

        @if($diagnosa->catatan_karyawan || $diagnosa->foto_bukti)
            <div class="mt-4 grid grid-cols-1 md:grid-cols-12 gap-4">
                @if($diagnosa->catatan_karyawan)
                    <div class="{{ $diagnosa->foto_bukti ? 'md:col-span-8' : 'md:col-span-12' }} p-4 rounded-2xl bg-amber-50/60 border border-amber-200 text-xs text-amber-900">
                        <span class="font-bold flex items-center gap-1 mb-1">
                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Catatan Lapangan Karyawan:
                        </span>
                        <p>{{ $diagnosa->catatan_karyawan }}</p>
                    </div>
                @endif
                @if($diagnosa->foto_bukti)
                    <div class="{{ $diagnosa->catatan_karyawan ? 'md:col-span-4' : 'md:col-span-12' }} p-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                        <span class="font-bold text-slate-700 block mb-1.5">Foto Bukti Lapangan:</span>
                        <img src="{{ asset('storage/' . $diagnosa->foto_bukti) }}" alt="Bukti Lapangan" class="w-full h-36 object-cover rounded-xl border border-slate-200">
                    </div>
                @endif
            </div>
        @endif

        @if($diagnosa->persentase_cf < 30)
            <div class="mt-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 flex items-start gap-2.5">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-bold">Indikasi Belum Kuat (&lt; 30%)</p>
                    <p class="mt-0.5">Gejala yang dimasukkan masih terlalu minim atau bersifat umum. Disarankan melakukan observasi lanjutan atau konsultasi langsung dengan Pengawas/Pakar.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Rekomendasi Solusi & Penanganan dari Pakar -->
    @if($diagnosa->penyakitTerpilih)
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="stethoscope" class="w-5 h-5 text-emerald-600"></i>
                        SOP Penanganan & Pengendalian (Instruksi Pakar Tanaman)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Petunjuk praktis untuk mencegah kerugian persemaian bibit cabai di Rumah Semai Helly Seedling.</p>
                </div>
            </div>

            <!-- Detail Solusi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Solusi Kuratif / Penanganan Saat Terinfeksi -->
                <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-2">
                    <h4 class="font-bold text-sm text-emerald-950 flex items-center gap-1.5">
                        <i data-lucide="shield-alert" class="w-4 h-4 text-emerald-700"></i>
                        Tindakan Kuratif (Saat Gejala Muncul)
                    </h4>
                    <div class="text-xs text-slate-700 space-y-2 leading-relaxed whitespace-pre-line">
                        {{ $diagnosa->penyakitTerpilih->solusi_penanganan }}
                    </div>
                </div>

                <!-- Solusi Preventif / Pencegahan -->
                <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-200/80 space-y-2">
                    <h4 class="font-bold text-sm text-teal-950 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-teal-700"></i>
                        Tindakan Pencegahan (Preventif)
                    </h4>
                    <div class="text-xs text-slate-700 space-y-2 leading-relaxed whitespace-pre-line">
                        {{ $diagnosa->penyakitTerpilih->tindakan_pencegahan ?? 'Lakukan rotasi varietas dan sanitasi berkala.' }}
                    </div>
                    @if($diagnosa->penyakitTerpilih->faktor_pemicu)
                        <div class="mt-3 pt-3 border-t border-teal-200/60 text-xs text-teal-900">
                            <strong>Faktor Pemicu Utama:</strong> {{ $diagnosa->penyakitTerpilih->faktor_pemicu }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Ranking Penyakit Lain Berdasarkan Certainty Factor -->
    @if(!empty($diagnosa->hasil_semua_penyakit_json))
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-emerald-600"></i>
                        Peringkat Probabilitas Penyakit Lainnya
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan persentase kepastian Certainty Factor dari seluruh kandidat penyakit.</p>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                @foreach($diagnosa->hasil_semua_penyakit_json as $index => $item)
                    @php
                        $percentage = $item['persentase'] ?? 0;
                        $isTop = $index === 0;
                    @endphp
                    <div class="p-3.5 rounded-2xl border {{ $isTop ? 'border-emerald-300 bg-emerald-50/40' : 'border-slate-200 bg-slate-50/40' }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-xl font-bold flex items-center justify-center text-xs {{ $isTop ? 'bg-emerald-600 text-white shadow' : 'bg-slate-200 text-slate-700' }}">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">
                                    {{ $item['kode_penyakit'] }} - {{ $item['nama_penyakit'] }}
                                </h4>
                                <span class="text-[11px] text-slate-500">{{ $item['confidence_level'] ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 sm:w-48">
                            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full {{ $isTop ? 'bg-emerald-600' : 'bg-slate-400' }}" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="font-mono text-xs font-bold text-slate-800 shrink-0">{{ $percentage }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- MODAL: Transparansi Rumus Matematis Certainty Factor -->
    <div x-show="mathModalOpen" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5" @click.outside="mathModalOpen = false">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        <i data-lucide="calculator" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Transparansi Perhitungan Certainty Factor (CF)</h3>
                        <p class="text-xs text-slate-500">Bukti matematis langkah demi langkah pembuktian skripsi.</p>
                    </div>
                </div>
                <button @click="mathModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Penjelasan Teori Rumus -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2 font-mono">
                <p><strong>1. Menghitung CF Tunggal Setiap Gejala:</strong></p>
                <p class="bg-white p-2 rounded-lg border border-slate-200 text-emerald-700 font-bold">
                    CF[H, E] = CF[User] &times; CF[Pakar]
                </p>
                <p><strong>2. Menggabungkan Beberapa CF Gejala untuk Penyakit yang Sama:</strong></p>
                <p class="bg-white p-2 rounded-lg border border-slate-200 text-emerald-700 font-bold">
                    CF_kombinasi = CF_lama + (CF_baru &times; (1 - CF_lama))
                </p>
            </div>

            <!-- Steps Real Calculation -->
            @php
                $bestItem = $diagnosa->hasil_semua_penyakit_json[0] ?? null;
            @endphp
            @if($bestItem && !empty($bestItem['symptom_breakdowns']))
                <div class="space-y-3">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-600">
                        Kalkulasi untuk Penyakit: <span class="text-emerald-700">{{ $bestItem['nama_penyakit'] }}</span>
                    </h4>

                    <!-- Gejala Tunggal -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-500">
                                    <th class="py-2">Kode Gejala</th>
                                    <th class="py-2">CF User</th>
                                    <th class="py-2">CF Pakar</th>
                                    <th class="py-2">CF Tunggal (User &times; Pakar)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-mono">
                                @foreach($bestItem['symptom_breakdowns'] as $s)
                                    <tr>
                                        <td class="py-2 font-bold">{{ $s['kode_gejala'] }}</td>
                                        <td class="py-2">{{ $s['user_weight'] }}</td>
                                        <td class="py-2">{{ $s['pakar_weight'] }}</td>
                                        <td class="py-2 font-bold text-emerald-700">{{ $s['cf_single'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Kombinasi Steps -->
                    @if(!empty($bestItem['cf_steps']))
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <h5 class="font-bold text-xs text-slate-800 mb-2">Langkah Kombinasi (CF Combine):</h5>
                            <div class="space-y-1.5 font-mono text-xs">
                                @foreach($bestItem['cf_steps'] as $step)
                                    <div class="p-2.5 rounded-xl bg-emerald-50/60 border border-emerald-200 text-slate-800">
                                        <span class="font-bold text-emerald-800">Langkah {{ $step['step'] }}:</span> {{ $step['formula'] }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3 p-3 rounded-xl bg-slate-900 text-white font-mono text-xs flex justify-between items-center">
                                <span>Hasil Akhir Persentase:</span>
                                <span class="font-bold text-emerald-400 text-sm">{{ $bestItem['cf_final'] }} &times; 100% = {{ $bestItem['persentase'] }}%</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="pt-3 border-t border-slate-100 flex justify-end">
                <button type="button" @click="mathModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold hover:bg-slate-700 transition">
                    Tutup Rincian
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Kirim Instruksi Tindakan (Khusus Pengawas) -->
    @if(auth()->user()->isPengawas())
        <div x-show="actionModalOpen" class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-4" @click.outside="actionModalOpen = false">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-base">Instruksikan Penanganan ke Karyawan</h3>
                    <button @click="actionModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('tindakans.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="diagnosa_id" value="{{ $diagnosa->id }}">
                    <input type="hidden" name="karyawan_id" value="{{ $diagnosa->user_id }}">

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tujuan Petak Semai</label>
                        <input type="text" readonly value="{{ $diagnosa->petak->kode_petak }} - {{ $diagnosa->petak->nama_petak }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 bg-slate-100 font-bold text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Instruksi Tindakan Lapangan</label>
                        <textarea name="instruksi_tindakan" rows="3" required class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ $diagnosa->penyakitTerpilih?->solusi_penanganan }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Rekomendasi Pestisida/Obat</label>
                            <input type="text" name="rekomendasi_pestisida" placeholder="Fungisida Mankozeb / dll" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Dosis Aplikasi</label>
                            <input type="text" name="dosis_aplikasi" placeholder="1.5 ml/L air" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" @click="actionModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                            Kirim ke Karyawan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection

