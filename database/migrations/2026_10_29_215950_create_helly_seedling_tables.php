<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Petak Semai (Plot Nursery)
        Schema::create('petaks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_petak', 20)->unique();
            $table->string('nama_petak', 100);
            $table->string('lokasi_blok', 50)->default('Blok A');
            $table->string('jenis_cabai', 100)->default('Cabai Rawit Merah');
            $table->integer('kapasitas_bibit')->default(5000);
            $table->integer('jumlah_bibit_aktif')->default(5000);
            $table->date('tanggal_semai');
            $table->enum('status_kesehatan', ['sehat', 'waspada', 'terinfeksi', 'kosong'])->default('sehat');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Master Penyakit Bibit Cabai
        Schema::create('penyakits', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penyakit', 10)->unique();
            $table->string('nama_penyakit', 150);
            $table->string('nama_latin', 150)->nullable();
            $table->string('penyebab', 150)->nullable();
            $table->text('deskripsi');
            $table->text('faktor_pemicu')->nullable();
            $table->text('solusi_penanganan');
            $table->text('tindakan_pencegahan')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->timestamps();
        });

        // 3. Tabel Master Gejala Bibit Cabai
        Schema::create('gejalas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gejala', 10)->unique();
            $table->string('nama_gejala', 255);
            $table->enum('kategori_bagian', ['daun', 'batang', 'akar', 'bibit_umum'])->default('daun');
            $table->text('deskripsi')->nullable();
            $table->string('pertanyaan_diagnosa', 255)->nullable();
            $table->timestamps();
        });

        // 4. Tabel Basis Aturan / Rule Base (Bobot Pakar CF)
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->foreignId('gejala_id')->constrained('gejalas')->onDelete('cascade');
            $table->decimal('bobot_pakar', 4, 2)->default(0.00); // 0.00 - 1.00
            $table->timestamps();
            $table->unique(['penyakit_id', 'gejala_id']);
        });

        // 5. Tabel Diagnosa Konsultasi
        Schema::create('diagnosas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_diagnosa', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('petak_id')->constrained('petaks')->onDelete('cascade');
            $table->foreignId('penyakit_terpilih_id')->nullable()->constrained('penyakits')->onDelete('set null');
            $table->decimal('nilai_cf_akhir', 6, 4)->default(0.0000);
            $table->decimal('persentase_cf', 5, 2)->default(0.00);
            $table->string('tingkat_keyakinan', 50)->default('Ragu');
            $table->json('hasil_semua_penyakit_json')->nullable();
            $table->enum('status_tindakan', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('catatan_karyawan')->nullable();
            $table->timestamps();
        });

        // 6. Tabel Detail Diagnosa (Gejala yang Dipilih Pengguna)
        Schema::create('diagnosa_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosa_id')->constrained('diagnosas')->onDelete('cascade');
            $table->foreignId('gejala_id')->constrained('gejalas')->onDelete('cascade');
            $table->decimal('nilai_keyakinan_user', 4, 2)->default(0.00);
            $table->string('keterangan_user', 50)->nullable();
            $table->timestamps();
        });

        // 7. Tabel Tindakan & Instruksi Penanganan
        Schema::create('tindakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosa_id')->constrained('diagnosas')->onDelete('cascade');
            $table->foreignId('petak_id')->constrained('petaks')->onDelete('cascade');
            $table->foreignId('pengawas_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('karyawan_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('instruksi_tindakan');
            $table->string('rekomendasi_pestisida', 150)->nullable();
            $table->string('dosis_aplikasi', 100)->nullable();
            $table->enum('status', ['menunggu', 'sedang_dikerjakan', 'selesai'])->default('menunggu');
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->text('catatan_pelaksanaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindakans');
        Schema::dropIfExists('diagnosa_details');
        Schema::dropIfExists('diagnosas');
        Schema::dropIfExists('rules');
        Schema::dropIfExists('gejalas');
        Schema::dropIfExists('penyakits');
        Schema::dropIfExists('petaks');
    }
};
