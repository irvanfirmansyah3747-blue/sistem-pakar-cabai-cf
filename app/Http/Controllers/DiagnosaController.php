<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\DiagnosaDetail;
use App\Models\Petak;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Services\CertaintyFactorService;
use Illuminate\Support\Str;

class DiagnosaController extends Controller
{
    protected CertaintyFactorService $cfService;

    public function __construct(CertaintyFactorService $cfService)
    {
        $this->cfService = $cfService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Diagnosa::with(['user', 'petak', 'penyakitTerpilih'])->latest();

        // Karyawan hanya melihat riwayatnya sendiri (sesuai batasan masalah skripsi)
        if ($user->isKaryawan()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('petak_id')) {
            $query->where('petak_id', $request->petak_id);
        }

        if ($request->filled('status')) {
            $query->where('status_tindakan', $request->status);
        }

        $diagnosas = $query->paginate(15)->withQueryString();
        $petaks = Petak::orderBy('kode_petak')->get();

        return view('diagnosa.index', compact('diagnosas', 'petaks'));
    }

    public function create()
    {
        $petaks = Petak::where('status_kesehatan', '!=', 'kosong')->orderBy('kode_petak')->get();
        if ($petaks->isEmpty()) {
            $petaks = Petak::orderBy('kode_petak')->get();
        }

        $gejalas = Gejala::orderBy('kategori_bagian')->orderBy('kode_gejala')->get();
        $gejalasByKategori = $gejalas->groupBy('kategori_bagian');

        return view('diagnosa.create', compact('petaks', 'gejalas', 'gejalasByKategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'petak_id' => 'required|exists:petaks,id',
            'gejalas' => 'required|array',
            'catatan_karyawan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $fotoBuktiPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('diagnosa_bukti', 'public');
        }

        $selectedSymptoms = $validated['gejalas']; // [gejala_id => weight]

        // Jalankan mesin Certainty Factor
        $result = $this->cfService->diagnose($selectedSymptoms);

        if ($result['status'] === 'no_symptoms' || empty($result['best_disease'])) {
            return back()->with('error', 'Silakan pilih minimal satu gejala yang dialami bibit dengan keyakinan di atas 0.');
        }

        $best = $result['best_disease'];
        $user = auth()->user();

        // Kode unik diagnosa DG-YYYYMMDD-XXXX
        $kodeDiagnosa = 'DG-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $diagnosa = Diagnosa::create([
            'kode_diagnosa' => $kodeDiagnosa,
            'user_id' => $user->id,
            'petak_id' => $validated['petak_id'],
            'penyakit_terpilih_id' => $best['penyakit_id'],
            'nilai_cf_akhir' => $best['cf_final'],
            'persentase_cf' => $best['persentase'],
            'tingkat_keyakinan' => $best['confidence_level'],
            'hasil_semua_penyakit_json' => $result['ranked_diseases'],
            'status_tindakan' => 'menunggu',
            'catatan_karyawan' => $validated['catatan_karyawan'],
            'foto_bukti' => $fotoBuktiPath,
        ]);

        // Simpan rincian gejala yang dipilih user
        $labels = [
            '1.00' => 'Sangat Yakin (1.0)',
            '0.80' => 'Yakin (0.8)',
            '0.60' => 'Cukup Yakin (0.6)',
            '0.40' => 'Sedikit Ragu (0.4)',
            '0.00' => 'Tidak Yakin (0.0)',
        ];

        foreach ($selectedSymptoms as $gejalaId => $weight) {
            $w = (float)$weight;
            if ($w > 0) {
                $formattedWeight = number_format($w, 2);
                DiagnosaDetail::create([
                    'diagnosa_id' => $diagnosa->id,
                    'gejala_id' => $gejalaId,
                    'nilai_keyakinan_user' => $w,
                    'keterangan_user' => $labels[$formattedWeight] ?? "Keyakinan ({$w})",
                ]);
            }
        }

        // Perbarui status kesehatan petak secara otomatis jika terindikasi penyakit
        $petak = Petak::find($validated['petak_id']);
        if ($petak) {
            if ($best['persentase'] >= 75.0) {
                $petak->update(['status_kesehatan' => 'terinfeksi']);
            } elseif ($best['persentase'] >= 45.0 && $petak->status_kesehatan === 'sehat') {
                $petak->update(['status_kesehatan' => 'waspada']);
            }
        }

        return redirect()->route('diagnosa.show', $diagnosa->id)
            ->with('success', "Diagnosa berhasil dihitung! Bibit terindikasi penyakit: {$best['nama_penyakit']} ({$best['persentase']}%)");
    }

    public function show(Diagnosa $diagnosa)
    {
        $user = auth()->user();

        // Batasi karyawan hanya melihat miliknya sendiri
        if ($user->isKaryawan() && $diagnosa->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat hasil diagnosa karyawan lain.');
        }

        $diagnosa->load(['user', 'petak', 'penyakitTerpilih', 'details.gejala', 'tindakans.pengawas']);

        return view('diagnosa.show', compact('diagnosa'));
    }

    public function destroy(Diagnosa $diagnosa)
    {
        $user = auth()->user();
        if (!$user->isPengawas()) {
            abort(403, 'Hanya pengawas yang dapat menghapus arsip diagnosa.');
        }

        $diagnosa->delete();
        return redirect()->route('diagnosa.index')->with('success', 'Data riwayat diagnosa berhasil dihapus.');
    }
}

