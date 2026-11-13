<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petak;
use App\Models\Diagnosa;

class PetakController extends Controller
{
    public function index()
    {
        $petaks = Petak::withCount('diagnosas')->orderBy('kode_petak')->get();
        return view('petaks.index', compact('petaks'));
    }

    public function show(Petak $petak)
    {
        $diagnosas = $petak->diagnosas()->with(['user', 'penyakitTerpilih'])->latest()->take(10)->get();
        $tindakans = $petak->tindakans()->with(['pengawas', 'karyawan'])->latest()->take(10)->get();

        return view('petaks.show', compact('petak', 'diagnosas', 'tindakans'));
    }

    public function create()
    {
        return view('petaks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_petak' => 'required|string|max:20|unique:petaks,kode_petak',
            'nama_petak' => 'required|string|max:100',
            'lokasi_blok' => 'required|string|max:50',
            'jenis_cabai' => 'required|string|max:100',
            'kapasitas_bibit' => 'required|integer|min:0',
            'jumlah_bibit_aktif' => 'required|integer|min:0',
            'tanggal_semai' => 'required|date',
            'status_kesehatan' => 'required|in:sehat,waspada,terinfeksi,kosong',
            'catatan' => 'nullable|string',
        ]);

        Petak::create($validated);

        return redirect()->route('petaks.index')->with('success', 'Petak semai berhasil ditambahkan.');
    }

    public function edit(Petak $petak)
    {
        return view('petaks.edit', compact('petak'));
    }

    public function update(Request $request, Petak $petak)
    {
        $validated = $request->validate([
            'kode_petak' => 'required|string|max:20|unique:petaks,kode_petak,' . $petak->id,
            'nama_petak' => 'required|string|max:100',
            'lokasi_blok' => 'required|string|max:50',
            'jenis_cabai' => 'required|string|max:100',
            'kapasitas_bibit' => 'required|integer|min:0',
            'jumlah_bibit_aktif' => 'required|integer|min:0',
            'tanggal_semai' => 'required|date',
            'status_kesehatan' => 'required|in:sehat,waspada,terinfeksi,kosong',
            'catatan' => 'nullable|string',
        ]);

        $petak->update($validated);

        return redirect()->route('petaks.index')->with('success', 'Data petak semai berhasil diperbarui.');
    }

    public function destroy(Petak $petak)
    {
        $petak->delete();
        return redirect()->route('petaks.index')->with('success', 'Petak semai berhasil dihapus.');
    }

    public function verifikasiSehat(Petak $petak)
    {
        $petak->update(['status_kesehatan' => 'sehat']);
        return back()->with('success', "Status petak {$petak->kode_petak} telah diverifikasi kembali menjadi Sehat.");
    }
}

