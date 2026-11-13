<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petak;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isPengawas()) {
            return $this->pengawasDashboard();
        } else {
            return $this->karyawanDashboard($user);
        }
    }

    private function pengawasDashboard()
    {
        $totalPetak = Petak::count();
        $petakSehat = Petak::where('status_kesehatan', 'sehat')->count();
        $petakWaspada = Petak::where('status_kesehatan', 'waspada')->count();
        $petakTerinfeksi = Petak::where('status_kesehatan', 'terinfeksi')->count();
        $petakKosong = Petak::where('status_kesehatan', 'kosong')->count();

        $totalBibit = Petak::sum('jumlah_bibit_aktif');
        $totalDiagnosa = Diagnosa::count();
        $totalPenyakit = Penyakit::count();
        $totalGejala = Gejala::count();
        $totalRules = Rule::count();
        $totalKaryawan = User::where('role', 'karyawan')->count();

        // Riwayat Diagnosa Terbaru
        $recentDiagnosas = Diagnosa::with(['user', 'petak', 'penyakitTerpilih'])
            ->latest()
            ->take(6)
            ->get();

        // Tindakan Perlu Perhatian
        $pendingTindakans = Tindakan::with(['petak', 'karyawan', 'diagnosa'])
            ->where('status', '!=', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        // Data Grafik: Sebaran Penyakit Berdasarkan Diagnosa
        $diseaseDistribution = Diagnosa::select('penyakit_terpilih_id', DB::raw('count(*) as total'))
            ->whereNotNull('penyakit_terpilih_id')
            ->groupBy('penyakit_terpilih_id')
            ->with('penyakitTerpilih')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->penyakitTerpilih?->nama_penyakit ?? 'Tidak Teridentifikasi',
                    'count' => $item->total,
                ];
            });

        // Data Grafik: Tren Kasus Diagnosa per Tanggal
        $trendData = Diagnosa::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(14)
            ->get();

        // Semua Petak untuk Peta Mini
        $allPetaks = Petak::orderBy('kode_petak')->get();

        return view('dashboard.pengawas', compact(
            'totalPetak',
            'petakSehat',
            'petakWaspada',
            'petakTerinfeksi',
            'petakKosong',
            'totalBibit',
            'totalDiagnosa',
            'totalPenyakit',
            'totalGejala',
            'totalRules',
            'totalKaryawan',
            'recentDiagnosas',
            'pendingTindakans',
            'diseaseDistribution',
            'trendData',
            'allPetaks'
        ));
    }

    private function karyawanDashboard($user)
    {
        $myDiagnosasCount = Diagnosa::where('user_id', $user->id)->count();
        $myPendingTasks = Tindakan::where('karyawan_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->with(['petak', 'diagnosa.penyakitTerpilih'])
            ->latest()
            ->get();

        $myRecentDiagnosas = Diagnosa::where('user_id', $user->id)
            ->with(['petak', 'penyakitTerpilih'])
            ->latest()
            ->take(5)
            ->get();

        $petakPerluPerhatian = Petak::whereIn('status_kesehatan', ['waspada', 'terinfeksi'])
            ->orderBy('status_kesehatan', 'desc')
            ->get();

        $allPetaks = Petak::orderBy('kode_petak')->get();

        return view('dashboard.karyawan', compact(
            'user',
            'myDiagnosasCount',
            'myPendingTasks',
            'myRecentDiagnosas',
            'petakPerluPerhatian',
            'allPetaks'
        ));
    }
}

