<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyakit;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakits = Penyakit::withCount(['rules', 'diagnosas'])->orderBy('kode_penyakit')->get();
        return view('penyakits.index', compact('penyakits'));
    }

    public function show(Penyakit $penyakit)
    {
        $penyakit->load(['rules.gejala', 'diagnosas.petak']);
        return view('penyakits.show', compact('penyakit'));
    }

    public function create()
    {
        return view('penyakits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakits,kode_penyakit',
            'nama_penyakit' => 'required|string|max:150',
            'nama_latin' => 'nullable|string|max:150',
            'penyebab' => 'nullable|string|max:150',
            'deskripsi' => 'required|string',
            'faktor_pemicu' => 'nullable|string',
            'solusi_penanganan' => 'required|string',
            'tindakan_pencegahan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('penyakits', 'public');
        }

        Penyakit::create($validated);

        return redirect()->route('penyakits.index')->with('success', 'Data penyakit berhasil ditambahkan.');
    }

    public function edit(Penyakit $penyakit)
    {
        return view('penyakits.edit', compact('penyakit'));
    }

    public function update(Request $request, Penyakit $penyakit)
    {
        $validated = $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakits,kode_penyakit,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:150',
            'nama_latin' => 'nullable|string|max:150',
            'penyebab' => 'nullable|string|max:150',
            'deskripsi' => 'required|string',
            'faktor_pemicu' => 'nullable|string',
            'solusi_penanganan' => 'required|string',
            'tindakan_pencegahan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('penyakits', 'public');
        }

        $penyakit->update($validated);

        return redirect()->route('penyakits.index')->with('success', 'Data penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();
        return redirect()->route('penyakits.index')->with('success', 'Penyakit berhasil dihapus.');
    }
}

