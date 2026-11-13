# 🌶️ Sistem Pakar Diagnosa Penyakit Bibit Tanaman Cabai (Certainty Factor)
### Rumah Semai Helly Seedling — Desa Sri Sawahan, Lampung Tengah

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-9%20Passed-379C0C?style=for-the-badge&logo=php&logoColor=white)

---

## 📥 File Dokumen Laporan Skripsi / UTS
Untuk kemudahan pengujian dan evaluasi akademik, file naskah dokumen laporan lengkap tersedia langsung di root repositori:
* 📘 **[Download Naskah Microsoft Word (.docx)](LAPORAN_LENGKAP_SISTEM_PAKAR.docx)** *(Format Standar Skripsi A4, Margin 4-3-3-3, Times New Roman 12pt, Cover Lengkap, dan 4 Diagram Visual Tersemat)*
* 📄 **[Buka Naskah Laporan Markdown (.md)](LAPORAN_LENGKAP_SISTEM_PAKAR.md)**

---

## 👨‍💻 Identitas Pengembang & Proyek
* **Penulis / Pengembang:** Dedy Dzulkarnain
* **NPM:** 22430059
* **Program Studi:** S1 Ilmu Komputer
* **Fakultas:** Fakultas Ilmu Komputer, Universitas Muhammadiyah Metro
* **Tahun Akademik:** 2026
* **Mata Kuliah:** Basis Data Lanjut (UTS) & Naskah Proyek Skripsi
* **Narasumber Pakar:** 
  1. Bpk. Helly Sumanto (Kepala Rumah Semai Helly Seedling)
  2. Bpk. Ino (Pakar Tanaman & Patologi Bibit)

---

## 📸 Tangkapan Layar Aplikasi (Screenshots)

Berikut adalah antarmuka utama implementasi sistem:

### 1. Halaman Autentikasi / Login
Antarmuka login dengan fitur *Quick Login (1-Click)* untuk Pengawas dan Karyawan Lapangan:
<p align="center">
  <img src="screenshot/halaman%20login.png" alt="Halaman Login" width="900">
</p>

### 2. Dashboard & Panel Pengawas (Pakar)
Panel kendali komprehensif bagi pengawas kebun mencakup statistik sebaran petak terinfeksi, verifikasi tindakan penanganan, dan manajemen basis pengetahuan:
<p align="center">
  <img src="screenshot/halaman%20pakar.png" alt="Dashboard Pengawas / Pakar" width="900">
</p>

### 3. Dashboard & Panel Karyawan Lapangan
Antarmuka operasional karyawan lapangan untuk melakukan konsultasi diagnosa penyakit mandiri, pemilihan gejala berbobot keyakinan, dan upload bukti tindakan:
<p align="center">
  <img src="screenshot/halaman%20karyawan.png" alt="Dashboard Karyawan Lapangan" width="900">
</p>

---

## 📊 Diagram Pemodelan Sistem

### 1. Use Case Diagram
Menggambarkan batasan sistem dan interaksi antara peran Karyawan Lapangan serta Pengawas / Pakar Kebun:
<p align="center">
  <img src="docs/diagrams/use_case.png" alt="Use Case Diagram" width="850">
</p>

### 2. Activity Diagram
Alur kerja kolaboratif proses konsultasi diagnosa, penerbitan surat tugas tindakan, dan verifikasi status petak:
<p align="center">
  <img src="docs/diagrams/activity.png" alt="Activity Diagram" width="850">
</p>

### 3. Flowchart Algoritma Engine Certainty Factor
Logika eksekusi inferensi pada service layer `CertaintyFactorService::diagnose()`:
<p align="center">
  <img src="docs/diagrams/flowchart.png" alt="Flowchart Algoritma CF" width="750">
</p>

### 4. Entity Relationship Diagram (ERD)
Struktur 9 tabel relasional (3NF), 1 MySQL Trigger, dan 1 Database View pada database `sp_hellyseedling_cf`:
<p align="center">
  <img src="docs/diagrams/erd.png" alt="Entity Relationship Diagram" width="950">
</p>

---

## 📖 NASKAH LAPORAN LENGKAP SISTEM (BAB I - BAB V)

### DAFTAR ISI LAPORAN
1. **BAB I: PENDAHULUAN** (1.1 Latar Belakang, 1.2 Rumusan Masalah, 1.3 Batasan Masalah, 1.4 Tujuan, 1.5 Manfaat)
2. **BAB II: LANDASAN TEORI & KAJIAN PUSTAKA** (2.1 Sistem Pakar, 2.2 Forward Chaining, 2.3 Certainty Factor, 2.4 Patologi Bibit Cabai, 2.5 Basis Data Lanjut MySQL, 2.6 Framework Laravel 11)
3. **BAB III: METODOLOGI PENELITIAN & ANALISIS SISTEM** (3.1 Objek Penelitian, 3.2 Teknik Pengumpulan Data, 3.3 RAD, 3.4 Analisis As-Is vs To-Be, 3.5 Pemodelan Terstruktur)
4. **BAB IV: PERANCANGAN BASIS DATA & IMPLEMENTASI SISTEM** (4.1 ERD, 4.2 Struktur Tabel, View & Trigger, 4.3 Basis Pengetahuan, 4.4 Algoritma CF, 4.5 Fitur Interaktif, 4.6 Pengujian PHPUnit)
5. **BAB V: KESIMPULAN & SARAN** (5.1 Kesimpulan, 5.2 Saran Pengembangan)
6. **DAFTAR PUSTAKA**

---

### BAB I: PENDAHULUAN

#### 1.1 Latar Belakang Masalah
Sektor pertanian tanaman hortikultura, khususnya cabai (*Capsicum annum L.*), memegang peranan strategis dalam stabilitas ekonomi dan ketahanan pangan masyarakat. Fase yang paling kritis dan menentukan keberhasilan budidaya cabai adalah fase persemaian (*seedling nursery*). Pada fase umur 1 sampai 25 hari setelah semai, bibit tanaman cabai berada dalam kondisi jaringan sel yang sangat lunak dan rentan terhadap serangan berbagai patogen mikroorganisme tular tanah (*soil-borne pathogens*), jamur, bakteri, maupun virus.

**Rumah Semai Helly Seedling**, yang berlokasi di Desa Sri Sawahan, Kabupaten Lampung Tengah, merupakan sentra pembibitan cabai profesional yang bertugas menyediakan bibit unggul berkualitas tinggi bagi jaringan petani cabai di wilayah Lampung Tengah dan sekitarnya. Pengelolaan persemaian dipimpin langsung oleh **Bpk. Helly Sumanto** dan didukung oleh pakar tanaman **Bpk. Ino**.

Dalam operasional harian, proses pemeliharaan dan pengendalian penyakit bibit cabai di Rumah Semai Helly Seedling menghadapi beberapa kendala kritis:
1. **Keterbatasan Kehadiran Fisik Pakar:** Pakar tanaman tidak dapat memantau setiap petak semai selama 24 jam sehari. Ketika muncul gejala anomali pada bibit, karyawan lapangan sering kali kesulitan menentukan identifikasi jenis penyakit secara akurat.
2. **Keterlambatan Instruksi Penanganan:** Alur pelaporan manual yang berjalan masih berupa laporan lisan dari karyawan ke pengawas. Hal ini memerlukan waktu penanganan yang cukup lama dan berisiko salah interpretasi pesan, padahal penyakit seperti Rebah Semai (*Damping Off*) dapat meluas dalam waktu kurang dari 48 jam.
3. **Ketiadaan Rekam Medis Digital Per Petak:** Pencatatan manual menyebabkan data riwayat serangan penyakit, penggunaan fungisida/pestisida, dan statistik persebaran penyakit tidak terdokumentasi dengan baik, rawan hilang, dan sulit dianalisis untuk mitigasi musim tanam berikutnya.
4. **Perbaikan Kelemahan Konsep Awal:** Pada dokumen penelitian awal ditemukan kekeliruan penulisan judul (*typo* "DIANOGSA"), antarmuka sistem yang kaku, ketiadaan bukti foto lapangan, belum adanya audit perubahan bobot pakar di tingkat basis data, serta metode *Certainty Factor* yang bekerja secara *black box* tanpa transparansi hitungan matematis.

Untuk memecahkan permasalahan di atas, dibangun sebuah **Sistem Pakar Diagnosa Penyakit Bibit Cabai Berbasis Web** yang mengadopsi metode inferensi **Forward Chaining** dan formula matematis **Certainty Factor (CF)** menggunakan framework **Laravel 11** dan basis data relasional **MySQL**.

#### 1.2 Rumusan Masalah
1. Bagaimana merancang basis data relasional ternormalisasi (3NF) pada MySQL beserta *Database View* dan *Database Trigger* untuk menampung data multi-peran, petak semai, master penyakit, gejala klinis, aturan pakar, log audit bobot, dan histori diagnosa?
2. Bagaimana mengimplementasikan metode *Certainty Factor* (CF) yang dikombinasikan dengan *Forward Chaining* ke dalam mesin inferensi sistem pakar secara presisi, transparan, dan menangani kasus gejala dengan keyakinan rendah (*low confidence*)?
3. Bagaimana membangun aplikasi berbasis web menggunakan Laravel 11 dengan antarmuka interaktif, validasi input yang jelas, serta pemisahan otoritas ketat antara Pengawas (Pakar) dan Karyawan Lapangan?

#### 1.3 Batasan Masalah
1. **Objek Penelitian:** Bibit tanaman cabai pada fase persemaian di Rumah Semai Helly Seedling, Desa Sri Sawahan, Kabupaten Lampung Tengah.
2. **Subjek Pakar:** Pengetahuan patologi dan bobot keyakinan pakar bersumber dari wawancara terstruktur dengan Bpk. Helly Sumanto dan Bpk. Ino.
3. **Cakupan Penyakit & Gejala:** Mencakup 5 penyakit utama fase semai (*Rebah Semai*, *Antraknosa Semai*, *Layu Bakteri*, *Bercak Daun Cercospora*, dan *Virus Kuning/Gemini*) serta 16 gejala klinis fisik pada daun, batang, akar, dan kondisi bibit umum.
4. **Pembagian Hak Akses Pengguna (*RBAC*):**
   * **Pengawas:** Hak penuh mengelola master penyakit, master gejala, aturan bobot CF pakar, denah petak semai, verifikasi pemulihan petak sehat, manajemen akun karyawan, menerbitkan surat tugas penanganan, serta melihat dan mencetak laporan statistik.
   * **Karyawan:** Hak terbatas untuk melihat lokasi petak semai, melakukan konsultasi diagnosa gejala (beserta upload foto bukti lapangan), melihat histori diagnosa pribadi, dan mengonfirmasi penyelesaian surat tugas penanganan.
5. **Lingkungan Pengembangan:** PHP 8.2+, Framework Laravel 11, MySQL / MariaDB, Tailwind CSS, Alpine.js, dan Chart.js.

#### 1.4 Tujuan Penelitian
1. Menghasilkan sistem basis data relasional yang kokoh, konsisten, dan dilengkapi fitur lanjut (*Database View* & *Trigger*) untuk pencatatan persemaian bibit cabai.
2. Menerapkan algoritma *Certainty Factor* dengan audit transparansi matematis *step-by-step* serta verifikasi otomatis melalui *Unit & Feature Testing*.
3. Membangun sistem informasi berbasis web yang responsif, interaktif, dan aman guna memangkas waktu penanganan penyakit dari pengawas ke karyawan lapangan secara *real-time*.

#### 1.5 Manfaat Penelitian
1. **Bagi Rumah Semai Helly Seedling:** Mempercepat respon penanganan bibit sakit, menekan angka kematian bibit, dan menyediakan arsip digital sebaran penyakit per bedengan.
2. **Bagi Karyawan Lapangan:** Menjadi asisten cerdas yang memandu identifikasi gejala penyakit secara mudah di lapangan lengkap dengan bukti foto.
3. **Bagi Dunia Akademik (Ilmu Komputer):** Menjadi referensi implementasi sistem pakar pertanian dan rekayasa basis data lanjut berbasis web Laravel 11.

---

### BAB II: LANDASAN TEORI & KAJIAN PUSTAKA

#### 2.1 Konsep Dasar Sistem Pakar (*Expert System*)
Sistem pakar adalah cabang kecerdasan buatan (*Artificial Intelligence*) yang mengadopsi pengetahuan pakar manusia ke dalam format komputasi. Komponen utamanya terdiri dari Basis Pengetahuan (*Knowledge Base*), Mesin Inferensi (*Inference Engine*), dan Antarmuka Pengguna (*User Interface*).

#### 2.2 Metode Penalaran *Forward Chaining*
*Forward Chaining* adalah strategi inferensi pelacakan maju yang berorientasi pada data (*data-driven reasoning*). Alur penalaran dimulai dari fakta-fakta gejala yang ditemukan karyawan di petak semai, kemudian dicocokkan dengan bagian premis (*IF*) pada basis aturan (`rules`) untuk menghasilkan kesimpulan penyakit (*THEN*).

#### 2.3 Metode *Certainty Factor* (CF)
Metode *Certainty Factor* diperkenalkan oleh Shortliffe dan Buchanan (1975) guna menangani penalaran yang mengandung ketidakpastian (*uncertainty*).

$$CF(H, E) = MB(H, E) - MD(H, E)$$

**Formula Perhitungan CF yang Diimplementasikan:**
1. **CF Gejala Tunggal:**
   $$CF_{tunggal} = CF(E) \times CF(H)$$
   * $CF(E)$ = Bobot keyakinan pengguna lapangan ($0.4 = \text{Kurang Yakin}, 0.6 = \text{Cukup Yakin}, 0.8 = \text{Yakin}, 1.0 = \text{Sangat Yakin}$).
   * $CF(H)$ = Bobot kepastian pakar tanaman ($0.05 - 1.00$).
2. **CF Kombinasi (*Combine Rule*):**
   $$CF_{kombinasi}(CF_1, CF_2) = CF_1 + CF_2 \times (1 - CF_1)$$
3. **Persentase Keyakinan Akhir:**
   $$\text{Akurasi (\%)} = CF_{akhir} \times 100\%$$
   *Jika nilai persentase tertinggi $< 30\%$, sistem otomatis menandai hasil sebagai **Low Confidence** (Indikasi Belum Kuat / Perlu Observasi Lanjut).*

#### 2.4 Patologi Bibit Tanaman Cabai
Fase bibit semai cabai rentan diserang 3 golongan patogen utama:
1. **Cendawan/Jamur Patogen:** *Pythium debaryanum / Rhizoctonia solani* (Rebah Semai), *Colletotrichum capsici* (Antraknosa Semai), *Cercospora capsici* (Bercak Daun).
2. **Bakteri Patogen:** *Ralstonia solanacearum* (Layu Bakteri) yang ditandai layu mendadak dan jaringan batang berlendir saat dipotong.
3. **Virus Tanaman:** *Pepper Yellow Leaf Curl Virus* (Virus Kuning / Gemini) dengan vektor kutu kebul.

#### 2.5 Basis Data Relasional, Normalisasi (3NF), View, & Trigger
Struktur database dirancang memenuhi Normalisasi 3NF untuk mencegah redundansi dan anomali manipulasi. Untuk memenuhi standar mata kuliah **Basis Data Lanjut**, sistem mengimplementasikan:
* **Database View (`v_rekap_sebaran_penyakit`):** View agregasi multi-tabel untuk menyajikan rekapitulasi real-time petak terinfeksi.
* **Database Trigger (`trg_rules_after_update`):** Trigger otomatis pada event `AFTER UPDATE` tabel `rules` untuk mencatat audit perubahan bobot pakar lama ke baru.

#### 2.6 Framework Laravel 11 & Arsitektur MVC + Service Layer
Aplikasi dibangun menggunakan **Laravel 11** dengan arsitektur **Model-View-Controller (MVC)** yang diperkaya dengan **Service Layer** (`CertaintyFactorService.php`) untuk pemisahan logika matematika inferensi murni dari Controller.

---

### BAB III: METODOLOGI PENELITIAN & ANALISIS SISTEM

#### 3.1 Objek & Waktu Penelitian
* **Tempat Penelitian:** Rumah Semai Helly Seedling, Desa Sri Sawahan, Kab. Lampung Tengah.
* **Subjek Observasi:** Bedengan semai bibit cabai varietas Rawit Merah (Ori 212, Asmoro) dan Cabai Keriting (Castilo, Lado F1).

#### 3.2 Teknik Pengumpulan Data
1. **Observasi Lapangan:** Pengamatan visual kondisi rumah semai dan pola serangan patogen.
2. **Wawancara Terstruktur:** Wawancara mendalam bersama Bpk. Helly Sumanto dan Bpk. Ino guna mengkalibrasi nilai $CF_{pakar}$.
3. **Studi Pustaka & Dokumentasi:** Pengumpulan literatur fitopatologi cabai dan arsip riwayat pembibitan.

#### 3.3 Metode Pengembangan Sistem (*RAD*)
Menggunakan metode **Rapid Application Development (RAD)** yang terdiri dari 4 tahapan:
1. *Requirements Planning*
2. *User Design*
3. *Construction*
4. *Cutover*

#### 3.4 Analisis Sistem Berjalan (*As-Is*) vs Sistem Usulan Baru (*To-Be*)

| Parameter | Sistem Berjalan (*As-Is*) | Sistem Usulan Baru (*To-Be*) |
|---|---|---|
| **Media Pelaporan** | Lisan atau pesan teks manual. | Web interaktif wizard diagnosa + upload foto bukti. |
| **Kehadiran Pakar** | Menunggu pengawas datang ke kebun. | Sistem pakar daring 24 jam berbasis CF. |
| **Transparansi Hitungan** | Tidak terukur (*feeling*). | Persentase akurasi + rincian rumus matematis per tahap. |
| **Distribusi & Pemulihan** | Instruksi lisan, status petak tidak terlacak. | Surat tugas digital, konfirmasi selesai semprot, & verifikasi petak sehat. |
| **Audit Basis Pengetahuan** | Tidak ada riwayat perubahan aturan. | Tercatat otomatis oleh MySQL Trigger ke `rule_audit_logs`. |

---

### BAB IV: PERANCANGAN BASIS DATA & IMPLEMENTASI SISTEM

#### 4.1 Perancangan Skema Database (ERD)
Sistem memiliki 9 tabel fisik utama yang saling berelasi:
* `users` ||--o{ `diagnosas`
* `users` ||--o{ `tindakans`
* `petaks` ||--o{ `diagnosas`
* `petaks` ||--o{ `tindakans`
* `penyakits` ||--o{ `rules`
* `gejalas` ||--o{ `rules`
* `penyakits` ||--o{ `diagnosas`
* `diagnosas` ||--|{ `diagnosa_details`
* `gejalas` ||--o{ `diagnosa_details`
* `diagnosas` ||--o{ `tindakans`
* `rules` ||--o{ `rule_audit_logs`

#### 4.2 Struktur Tabel, Database View, & Trigger MySQL

##### SQL Trigger MySQL (`trg_rules_after_update`):
```sql
CREATE TRIGGER trg_rules_after_update
AFTER UPDATE ON rules
FOR EACH ROW
BEGIN
    IF OLD.cf_pakar <> NEW.cf_pakar THEN
        INSERT INTO rule_audit_logs (
            rule_id, penyakit_id, gejala_id,
            cf_pakar_lama, cf_pakar_baru,
            aksi, keterangan, created_at, updated_at
        ) VALUES (
            OLD.id, OLD.penyakit_id, OLD.gejala_id,
            OLD.cf_pakar, NEW.cf_pakar,
            'UPDATE', 'Otomatis dicatat oleh Trigger MySQL trg_rules_after_update',
            NOW(), NOW()
        );
    END IF;
END;
```

##### SQL Database View MySQL (`v_rekap_sebaran_penyakit`):
```sql
CREATE VIEW v_rekap_sebaran_penyakit AS
SELECT 
    p.id AS petak_id,
    p.kode_petak,
    p.nama_petak,
    p.lokasi_blok,
    p.jenis_cabai,
    p.status_kesehatan,
    COUNT(d.id) AS total_diagnosa,
    MAX(d.created_at) AS diagnosa_terakhir,
    py.nama_penyakit AS penyakit_terakhir,
    d.persentase AS persentase_terakhir
FROM petaks p
LEFT JOIN diagnosas d ON p.id = d.petak_id
LEFT JOIN penyakits py ON d.penyakit_id = py.id
GROUP BY p.id, p.kode_petak, p.nama_petak, p.lokasi_blok, p.jenis_cabai, p.status_kesehatan, py.nama_penyakit, d.persentase;
```

#### 4.3 Basis Pengetahuan (*Knowledge Base*) & Aturan Pakar
Sistem memuat 5 penyakit utama dan 16 gejala klinis terkalibrasi pakar:
* **P01 Rebah Semai (*Damping-Off*):** Batang pangkal busuk/rebah, akar membusuk, layu mendadak berkelompok.
* **P02 Antraknosa Semai:** Bercak cokelat kehitaman melingkar pada daun/batang, mati pucuk.
* **P03 Layu Bakteri:** Daun layu cepat saat hijau segar, lendir bakteri keluar saat pangkal dicelup air.
* **P04 Virus Kuning (Gemini):** Helai daun menguning cerah, daun mengecil dan keriting ke atas, bibit kerdil.
* **P05 Bercak Daun Cercospora:** Bercak bulat konsentris dengan titik putih abu-abu di bagian tengah bercak.

#### 4.4 Implementasi Algoritma Engine *Certainty Factor*
Alur logika inferensi pada `app/Services/CertaintyFactorService.php`:
1. Menyaring gejala dengan bobot input user $CF_{user} > 0$.
2. Mengambil relasi aturan dari database MySQL untuk seluruh penyakit yang cocok.
3. Menghitung nilai CF tunggal per gejala: $CF_{tunggal} = CF_{user} \times CF_{pakar}$.
4. Melakukan kombinasi berurutan (*sequential combination*):
   $$CF_{combine} = CF_{lama} + CF_{baru} \times (1 - CF_{lama})$$
5. Mengurutkan hasil dari persentase terbesar dan menandai status `is_low_confidence = true` jika skor tertinggi $< 30\%$.

#### 4.5 Hasil Pengujian Sistem (*Automated PHPUnit Testing*)
Seluruh pengujian unit dan fitur lulus 100% (**9 Passed, 27 Assertions**):
* `CertaintyFactorServiceTest`: Lulus uji kombinasi formula matematis CF dan deteksi *low confidence*.
* `AccessControlAndDiagnosaTest`: Lulus uji keamanan RBAC (karyawan diblokir dari master aturan) dan uji alur diagnosa.
* `ExampleTest`: Lulus uji kesehatan routing dan status response aplikasi.

---

### BAB V: KESIMPULAN & SARAN

#### 5.1 Kesimpulan
1. Berhasil dirancang basis data relasional ternormalisasi 3NF pada MySQL (`sp_hellyseedling_cf`) dengan dukungan Database View dan Database Trigger untuk audit otomatis perubahan basis pengetahuan.
2. Algoritma inferensi *Forward Chaining* dan metode *Certainty Factor* (CF) berhasil diterapkan secara presisi, transparan, dan terverifikasi secara matematis.
3. Aplikasi web berbasis Laravel 11 berhasil menyajikan solusi digital terintegrasi yang memangkas waktu penanganan penyakit bibit cabai di Rumah Semai Helly Seedling.

#### 5.2 Saran Pengembangan
1. **Computer Vision:** Pengembangan modul deteksi otomatis penyakit bibit cabai menggunakan citra kamera (*Deep Learning / CNN*).
2. **Sensor IoT Greenhouse:** Integrasi sensor kelembapan udara dan suhu tanah untuk sistem deteksi dini (*early warning system*).
3. **Notifikasi WhatsApp:** Pengiriman notifikasi surat tugas langsung ke ponsel karyawan melalui WhatsApp Gateway API.

---

### DAFTAR PUSTAKA
1. Buchanan, B. G., & Shortliffe, E. H. (1984). *Rule-Based Expert Systems: The MYCIN Experiments of the Stanford Heuristic Programming Project*. Addison-Wesley.
2. Pressman, R. S., & Maxim, B. R. (2020). *Software Engineering: A Practitioner's Approach*. McGraw-Hill Education.
3. Agrios, G. N. (2005). *Plant Pathology (5th Edition)*. Academic Press.
4. Semangun, H. (2007). *Penyakit-Penyakit Tanaman Hortikultura di Indonesia*. Gadjah Mada University Press.
5. Taylor, O. (2024). *Laravel: Up & Running: A Framework for Building Modern PHP Apps*. O'Reilly Media.

---

## 🚀 Panduan Instalasi & Menjalankan Sistem

### Prasyarat Sistem
* PHP $\ge$ 8.2 (ekstensi: `pdo_mysql`, `mbstring`, `zip`, `xml`, `gd`)
* Composer $\ge$ 2.0
* MySQL Server / XAMPP (port default `3306`)

### Langkah Cepat Menjalankan Sistem
1. Clone repositori & install dependensi:
   ```bash
   git clone https://github.com/irvanfirmansyah3747-blue/sistem-pakar-cabai-cf.git
   cd sistem-pakar-cabai-cf
   composer install
   ```
2. Konfigurasi `.env` & migrate database:
   ```bash
   copy .env.example .env
   php artisan key:generate
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```
3. Jalankan aplikasi dengan satu perintah:
   ```powershell
   gas
   ```
   *Buka browser di `http://localhost:8000`*.

---

## 🔑 Kredensial Akun Default

| Peran | Username | Password | Keterangan |
|:---|:---|:---|:---|
| **Pengawas (Pakar)** | `pengawas` | `password` | Akses Penuh: Master Penyakit, Gejala, Aturan CF, Audit Log, & Verifikasi |
| **Karyawan Lapangan** | `karyawan` | `password` | Akses Lapangan: Diagnosa Mandiri, Riwayat, & Pelaksanaan Surat Tugas |

---

## 📜 Lisensi
Proyek ini dikembangkan untuk keperluan akademik tugas UTS Basis Data Lanjut & Proyek Skripsi pada Universitas Muhammadiyah Metro.
Dilisensikan di bawah [MIT License](LICENSE).
