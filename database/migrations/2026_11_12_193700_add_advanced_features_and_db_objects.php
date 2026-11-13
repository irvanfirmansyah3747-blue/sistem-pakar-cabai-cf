<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom foto_bukti pada diagnosas untuk bukti visual lapangan
        Schema::table('diagnosas', function (Blueprint $table) {
            $table->string('foto_bukti', 255)->nullable()->after('catatan_karyawan');
        });

        // 2. Tabel Audit Log Perubahan Bobot Pakar (Basis Data Lanjut)
        Schema::create('rule_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('penyakit_id');
            $table->unsignedBigInteger('gejala_id');
            $table->decimal('bobot_lama', 4, 2);
            $table->decimal('bobot_baru', 4, 2);
            $table->string('aksi', 20)->default('UPDATE');
            $table->timestamp('changed_at')->useCurrent();
        });

        // 3. MySQL Trigger & View (untuk RDBMS MySQL / MariaDB)
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            DB::unprepared('DROP TRIGGER IF EXISTS trg_rules_after_update');
            DB::unprepared('
                CREATE TRIGGER trg_rules_after_update
                AFTER UPDATE ON rules
                FOR EACH ROW
                BEGIN
                    IF OLD.bobot_pakar <> NEW.bobot_pakar THEN
                        INSERT INTO rule_audit_logs (rule_id, penyakit_id, gejala_id, bobot_lama, bobot_baru, aksi, changed_at)
                        VALUES (NEW.id, NEW.penyakit_id, NEW.gejala_id, OLD.bobot_pakar, NEW.bobot_pakar, "UPDATE", NOW());
                    END IF;
                END
            ');

            DB::unprepared('
                CREATE OR REPLACE VIEW v_rekap_sebaran_penyakit AS
                SELECT
                    p.kode_penyakit,
                    p.nama_penyakit,
                    pt.lokasi_blok,
                    pt.kode_petak,
                    pt.nama_petak,
                    COUNT(d.id) AS total_kasus,
                    ROUND(AVG(d.persentase_cf), 2) AS rata_rata_cf,
                    MAX(d.created_at) AS kasus_terakhir
                FROM diagnosas d
                INNER JOIN penyakits p ON d.penyakit_terpilih_id = p.id
                INNER JOIN petaks pt ON d.petak_id = pt.id
                GROUP BY p.kode_penyakit, p.nama_penyakit, pt.lokasi_blok, pt.kode_petak, pt.nama_petak
            ');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            DB::unprepared('DROP VIEW IF EXISTS v_rekap_sebaran_penyakit');
            DB::unprepared('DROP TRIGGER IF EXISTS trg_rules_after_update');
        }

        Schema::dropIfExists('rule_audit_logs');

        Schema::table('diagnosas', function (Blueprint $table) {
            $table->dropColumn('foto_bukti');
        });
    }
};

