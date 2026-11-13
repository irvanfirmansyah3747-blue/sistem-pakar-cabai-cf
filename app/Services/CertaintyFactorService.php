<?php

namespace App\Services;

use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;

class CertaintyFactorService
{
    /**
     * Hitung Certainty Factor berdasarkan gejala terpilih dan keyakinan user
     * 
     * @param array $selectedSymptoms [gejala_id => float user_weight]
     * @return array
     */
    public function diagnose(array $selectedSymptoms): array
    {
        // Filter hanya gejala dengan bobot user > 0
        $activeSymptoms = array_filter($selectedSymptoms, fn($weight) => (float)$weight > 0);

        if (empty($activeSymptoms)) {
            return [
                'status' => 'no_symptoms',
                'best_disease' => null,
                'ranked_diseases' => [],
            ];
        }

        $activeGejalaIds = array_keys($activeSymptoms);

        // Ambil semua penyakit beserta relasi rules untuk gejala yang terpilih
        $penyakits = Penyakit::with(['rules' => function ($query) use ($activeGejalaIds) {
            $query->whereIn('gejala_id', $activeGejalaIds)->with('gejala');
        }])->get();

        $rankedDiseases = [];

        foreach ($penyakits as $penyakit) {
            $matchedRules = $penyakit->rules;

            if ($matchedRules->isEmpty()) {
                continue;
            }

            $cfSteps = [];
            $symptomBreakdowns = [];
            $combinedCf = 0.0;

            foreach ($matchedRules as $index => $rule) {
                $gejalaId = $rule->gejala_id;
                $userWeight = (float)($activeSymptoms[$gejalaId] ?? 0);
                $pakarWeight = (float)$rule->bobot_pakar;

                // CF(H, E) = CF(E) * CF(H)
                $cfSingle = round($userWeight * $pakarWeight, 4);

                $symptomBreakdowns[] = [
                    'kode_gejala' => $rule->gejala->kode_gejala,
                    'nama_gejala' => $rule->gejala->nama_gejala,
                    'user_weight' => $userWeight,
                    'pakar_weight' => $pakarWeight,
                    'cf_single' => $cfSingle,
                ];

                if ($index === 0) {
                    $combinedCf = $cfSingle;
                    $cfSteps[] = [
                        'step' => 1,
                        'gejala' => $rule->gejala->kode_gejala,
                        'formula' => "CF_old = CF({$rule->gejala->kode_gejala}) = {$userWeight} * {$pakarWeight} = {$cfSingle}",
                        'result' => $combinedCf,
                    ];
                } else {
                    $prevCf = $combinedCf;
                    // CF_combine = CF_old + CF_new * (1 - CF_old)
                    $combinedCf = round($prevCf + ($cfSingle * (1 - $prevCf)), 4);
                    $cfSteps[] = [
                        'step' => $index + 1,
                        'gejala' => $rule->gejala->kode_gejala,
                        'formula' => "CF_comb = {$prevCf} + ({$cfSingle} * (1 - {$prevCf})) = {$combinedCf}",
                        'result' => $combinedCf,
                    ];
                }
            }

            $percentage = round($combinedCf * 100, 2);

            $rankedDiseases[] = [
                'penyakit_id' => $penyakit->id,
                'kode_penyakit' => $penyakit->kode_penyakit,
                'nama_penyakit' => $penyakit->nama_penyakit,
                'nama_latin' => $penyakit->nama_latin,
                'solusi_penanganan' => $penyakit->solusi_penanganan,
                'cf_final' => $combinedCf,
                'persentase' => $percentage,
                'confidence_level' => $this->getConfidenceLabel($percentage),
                'is_low_confidence' => $percentage < 30.0,
                'matched_count' => count($symptomBreakdowns),
                'total_rules' => $penyakit->rules()->count(),
                'symptom_breakdowns' => $symptomBreakdowns,
                'cf_steps' => $cfSteps,
            ];
        }

        // Urutkan dari persentase tertinggi
        usort($rankedDiseases, fn($a, $b) => $b['cf_final'] <=> $a['cf_final']);

        $bestDisease = $rankedDiseases[0] ?? null;

        return [
            'status' => 'success',
            'best_disease' => $bestDisease,
            'ranked_diseases' => $rankedDiseases,
        ];
    }

    /**
     * Predikat tingkat keyakinan dalam bahasa manusia
     */
    public function getConfidenceLabel(float $percentage): string
    {
        return match (true) {
            $percentage >= 85.0 => 'Sangat Yakin / Akurat Tinggi',
            $percentage >= 70.0 => 'Yakin / Kemungkinan Besar',
            $percentage >= 50.0 => 'Cukup Yakin / Terindikasi',
            $percentage >= 30.0 => 'Kurang Yakin / Gejala Awal',
            default => 'Sangat Rendah / Belum Cukup Bukti',
        };
    }
}

