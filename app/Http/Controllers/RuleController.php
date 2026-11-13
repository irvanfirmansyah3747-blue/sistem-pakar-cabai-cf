<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;
use App\Models\Penyakit;
use App\Models\Gejala;

class RuleController extends Controller
{
    public function index(Request $request)
    {
        $penyakitFilter = $request->query('penyakit_id');

        $query = Rule::with(['penyakit', 'gejala'])->latest();

        if ($penyakitFilter) {
            $query->where('penyakit_id', $penyakitFilter);
        }

        $rules = $query->paginate(20)->withQueryString();
        $penyakits = Penyakit::orderBy('kode_penyakit')->get();
        $gejalas = Gejala::orderBy('kode_gejala')->get();

        return view('rules.index', compact('rules', 'penyakits', 'gejalas', 'penyakitFilter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id',
            'gejala_id' => 'required|exists:gejalas,id',
            'bobot_pakar' => 'required|numeric|min:0.01|max:1.00',
        ]);

        $exists = Rule::where('penyakit_id', $validated['penyakit_id'])
                      ->where('gejala_id', $validated['gejala_id'])
                      ->exists();

        if ($exists) {
            return back()->with('error', 'Aturan relasi antara penyakit dan gejala ini sudah ada.');
        }

        Rule::create($validated);

        return redirect()->route('rules.index')->with('success', 'Aturan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Rule $rule)
    {
        $validated = $request->validate([
            'bobot_pakar' => 'required|numeric|min:0.01|max:1.00',
        ]);

        $rule->update($validated);

        return redirect()->route('rules.index')->with('success', 'Bobot pakar berhasil diperbarui.');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return redirect()->route('rules.index')->with('success', 'Aturan berhasil dihapus.');
    }
}

