<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;
use App\Services\CertaintyFactorService;

class CertaintyFactorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_no_symptoms_when_all_weights_zero(): void
    {
        $service = new CertaintyFactorService();
        $result = $service->diagnose([1 => 0.0, 2 => 0.0]);

        $this->assertEquals('no_symptoms', $result['status']);
        $this->assertNull($result['best_disease']);
    }

    public function test_calculates_single_and_combined_certainty_factor_accurately(): void
    {
        $penyakit = Penyakit::create([
            'kode_penyakit' => 'P01',
            'nama_penyakit' => 'Rebah Semai',
            'deskripsi' => 'Deskripsi',
            'solusi_penanganan' => 'Solusi',
        ]);

        $g1 = Gejala::create(['kode_gejala' => 'G01', 'nama_gejala' => 'Gejala 1', 'kategori_bagian' => 'batang']);
        $g2 = Gejala::create(['kode_gejala' => 'G02', 'nama_gejala' => 'Gejala 2', 'kategori_bagian' => 'batang']);
        $g3 = Gejala::create(['kode_gejala' => 'G12', 'nama_gejala' => 'Gejala 12', 'kategori_bagian' => 'akar']);

        Rule::create(['penyakit_id' => $penyakit->id, 'gejala_id' => $g1->id, 'bobot_pakar' => 0.95]);
        Rule::create(['penyakit_id' => $penyakit->id, 'gejala_id' => $g2->id, 'bobot_pakar' => 0.85]);
        Rule::create(['penyakit_id' => $penyakit->id, 'gejala_id' => $g3->id, 'bobot_pakar' => 0.80]);

        $service = new CertaintyFactorService();
        $result = $service->diagnose([
            $g1->id => 1.0,
            $g2->id => 0.8,
            $g3->id => 0.8,
        ]);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('P01', $result['best_disease']['kode_penyakit']);
        // 0.95 + 0.68*(1-0.95) = 0.984; 0.984 + 0.64*(1-0.984) = 0.99424 -> 99.42%
        $this->assertEquals(99.42, $result['best_disease']['persentase']);
        $this->assertFalse($result['best_disease']['is_low_confidence']);
    }

    public function test_flags_low_confidence_below_30_percent(): void
    {
        $penyakit = Penyakit::create([
            'kode_penyakit' => 'P04',
            'nama_penyakit' => 'Bercak Daun',
            'deskripsi' => 'Deskripsi',
            'solusi_penanganan' => 'Solusi',
        ]);

        $g = Gejala::create(['kode_gejala' => 'G06', 'nama_gejala' => 'Gejala 6', 'kategori_bagian' => 'daun']);
        Rule::create(['penyakit_id' => $penyakit->id, 'gejala_id' => $g->id, 'bobot_pakar' => 0.60]);

        $service = new CertaintyFactorService();
        $result = $service->diagnose([$g->id => 0.4]); // 0.60 * 0.40 = 0.24 = 24%

        $this->assertEquals(24.0, $result['best_disease']['persentase']);
        $this->assertTrue($result['best_disease']['is_low_confidence']);
    }
}

