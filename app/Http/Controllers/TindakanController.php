<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tindakan;
use App\Models\Diagnosa;
use App\Models\User;
use App\Models\Petak;

class TindakanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Tindakan::with(['diagnosa.penyakitTerpilih', 'petak', 'pengawas', 'karyawan'])->latest();

        if ($user->isKaryawan()) {
            $query->where('karyawan_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tindakans = $query->paginate(15)->withQueryString();

        return view('tindakans.index', compact('tindakans'));
    }

    public function create(Request $request)
    {
        $diagnosaId = $request->query('diagnosa_id');
        $diagnosa = Diagnosa::with(['petak', 'penyakitTerpilih', 'user'])->findOrFail($diagnosaId);
        $karyawans = User::where('role', 'karyawan')->where('is_active', true)->get();

        return view('tindakans.create', compact('diagnosa', 'karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'diagnosa_id' => 'required|exists:diagnosas,id',
            'karyawan_id' => 'nullable|exists:users,id',
            'instruksi_tindakan' => 'required|string',
            'rekomendasi_pestisida' => 'nullable|string|max:150',
            'dosis_aplikasi' => 'nullable|string|max:100',
        ]);

        $diagnosa = Diagnosa::findOrFail($validated['diagnosa_id']);

        $tindakan = Tindakan::create([
            'diagnosa_id' => $diagnosa->id,
            'petak_id' => $diagnosa->petak_id,
            'pengawas_id' => auth()->id(),
            'karyawan_id' => $validated['karyawan_id'] ?? $diagnosa->user_id,
            'instruksi_tindakan' => $validated['instruksi_tindakan'],
            'rekomendasi_pestisida' => $validated['rekomendasi_pestisida'],
            'dosis_aplikasi' => $validated['dosis_aplikasi'],
            'status' => 'menunggu',
        ]);

        $diagnosa->update(['status_tindakan' => 'diproses']);

        return redirect()->route('diagnosa.show', $diagnosa->id)
            ->with('success', 'Instruksi tindakan penanganan berhasil dikirimkan ke karyawan.');
    }

    public function updateStatus(Request $request, Tindakan $tindakan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,sedang_dikerjakan,selesai',
            'catatan_pelaksanaan' => 'nullable|string',
        ]);

        $tindakan->update([
            'status' => $validated['status'],
            'tanggal_pelaksanaan' => $validated['status'] === 'selesai' ? now()->toDateString() : $tindakan->tanggal_pelaksanaan,
            'catatan_pelaksanaan' => $validated['catatan_pelaksanaan'],
        ]);

        if ($validated['status'] === 'selesai') {
            $tindakan->diagnosa->update(['status_tindakan' => 'selesai']);
            
            // Bila selesai ditangani, status petak bisa dinilai pulih (waspada/sehat)
            $petak = $tindakan->petak;
            if ($petak && $petak->status_kesehatan === 'terinfeksi') {
                $petak->update(['status_kesehatan' => 'waspada']);
            }
        }

        return back()->with('success', 'Status pelaksanaan tindakan penanganan berhasil diperbarui.');
    }
}

