<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\Penyakit;
use App\Models\Petak;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $petakId = $request->query('petak_id');
        $penyakitId = $request->query('penyakit_id');

        $query = Diagnosa::with(['user', 'petak', 'penyakitTerpilih'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        if ($petakId) {
            $query->where('petak_id', $petakId);
        }

        if ($penyakitId) {
            $query->where('penyakit_terpilih_id', $penyakitId);
        }

        $diagnosas = $query->latest()->get();

        // Statistik Penyakit Terbanyak
        $diseaseStats = Diagnosa::select('penyakit_terpilih_id', DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->whereNotNull('penyakit_terpilih_id')
            ->groupBy('penyakit_terpilih_id')
            ->with('penyakitTerpilih')
            ->orderByDesc('total')
            ->get();

        // Statistik Kasus per Petak
        $petakStats = Diagnosa::select('petak_id', DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('petak_id')
            ->with('petak')
            ->orderByDesc('total')
            ->get();

        $allPetaks = Petak::orderBy('kode_petak')->get();
        $allPenyakits = Penyakit::orderBy('kode_penyakit')->get();

        return view('laporan.index', compact(
            'diagnosas',
            'diseaseStats',
            'petakStats',
            'allPetaks',
            'allPenyakits',
            'startDate',
            'endDate',
            'petakId',
            'penyakitId'
        ));
    }

    public function cetak(Request $request)
    {
        $startDate = $request->query('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $petakId = $request->query('petak_id');
        $penyakitId = $request->query('penyakit_id');

        $query = Diagnosa::with(['user', 'petak', 'penyakitTerpilih', 'details.gejala'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        if ($petakId) {
            $query->where('petak_id', $petakId);
        }

        if ($penyakitId) {
            $query->where('penyakit_terpilih_id', $penyakitId);
        }

        $diagnosas = $query->latest()->get();
        $pengawas = auth()->user();

        return view('laporan.cetak', compact('diagnosas', 'startDate', 'endDate', 'pengawas'));
    }
}

