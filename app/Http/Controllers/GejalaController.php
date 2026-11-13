<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;

class GejalaController extends Controller
{
    public function index()
    {
        $gejalas = Gejala::withCount('rules')->orderBy('kode_gejala')->get();
        return view('gejalas.index', compact('gejalas'));
    }

    public function create()
    {
        return view('gejalas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:10|unique:gejalas,kode_gejala',
            'nama_gejala' => 'required|string|max:255',
            'kategori_bagian' => 'required|in:daun,batang,akar,bibit_umum',
            'deskripsi' => 'nullable|string',
            'pertanyaan_diagnosa' => 'nullable|string|max:255',
        ]);

        Gejala::create($validated);

        return redirect()->route('gejalas.index')->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala)
    {
        return view('gejalas.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:10|unique:gejalas,kode_gejala,' . $gejala->id,
            'nama_gejala' => 'required|string|max:255',
            'kategori_bagian' => 'required|in:daun,batang,akar,bibit_umum',
            'deskripsi' => 'nullable|string',
            'pertanyaan_diagnosa' => 'nullable|string|max:255',
        ]);

        $gejala->update($validated);

        return redirect()->route('gejalas.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('gejalas.index')->with('success', 'Gejala berhasil dihapus.');
    }
}

