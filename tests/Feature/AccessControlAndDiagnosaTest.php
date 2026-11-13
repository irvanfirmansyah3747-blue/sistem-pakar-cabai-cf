<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\HellySeedlingSeeder;
use App\Models\User;
use App\Models\Petak;
use App\Models\Gejala;
use App\Models\Diagnosa;

class AccessControlAndDiagnosaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(HellySeedlingSeeder::class);
    }

    public function test_pengawas_can_access_admin_routes(): void
    {
        $pengawas = User::where('role', 'pengawas')->first();

        $this->actingAs($pengawas)->get('/dashboard')->assertStatus(200);
        $this->actingAs($pengawas)->get('/rules')->assertStatus(200);
        $this->actingAs($pengawas)->get('/karyawan')->assertStatus(200);
        $this->actingAs($pengawas)->get('/laporan')->assertStatus(200);
    }

    public function test_karyawan_is_blocked_from_pengawas_routes(): void
    {
        $karyawan = User::where('role', 'karyawan')->first();

        $this->actingAs($karyawan)->get('/dashboard')->assertStatus(200);
        $this->actingAs($karyawan)->get('/rules')->assertStatus(403);
        $this->actingAs($karyawan)->get('/karyawan')->assertStatus(403);
        $this->actingAs($karyawan)->get('/laporan')->assertStatus(403);
    }

    public function test_karyawan_can_submit_diagnosa_and_updates_petak_status(): void
    {
        $karyawan = User::where('role', 'karyawan')->first();
        $petak = Petak::where('kode_petak', 'PTK-A01')->first();
        $g01 = Gejala::where('kode_gejala', 'G01')->first();
        $g02 = Gejala::where('kode_gejala', 'G02')->first();

        $response = $this->actingAs($karyawan)->post('/diagnosa', [
            'petak_id' => $petak->id,
            'gejalas' => [
                $g01->id => 1.0,
                $g02->id => 0.8,
            ],
            'catatan_karyawan' => 'Pengujian otomatis sistem pakar.',
        ]);

        $response->assertRedirect();
        $this->assertEquals('terinfeksi', $petak->fresh()->status_kesehatan);
    }

    public function test_pengawas_can_open_tindakans_create_and_verify_petak_healthy(): void
    {
        $pengawas = User::where('role', 'pengawas')->first();
        $diagnosa = Diagnosa::first();
        $petak = Petak::where('kode_petak', 'PTK-B01')->first();

        $this->actingAs($pengawas)
            ->get('/tindakans-baru?diagnosa_id=' . $diagnosa->id)
            ->assertStatus(200);

        $this->actingAs($pengawas)
            ->patch('/petaks/' . $petak->id . '/verifikasi-sehat')
            ->assertRedirect();

        $this->assertEquals('sehat', $petak->fresh()->status_kesehatan);
    }
}

