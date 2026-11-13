<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Petak;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;
use App\Models\Diagnosa;
use App\Models\DiagnosaDetail;
use App\Models\Tindakan;
use Illuminate\Support\Facades\Hash;

class HellySeedlingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna
        $pengawas = User::create([
            'name' => 'Bpk. Helly Sumanto (Pakar / Pengawas)',
            'username' => 'pengawas',
            'email' => 'pengawas@hellyseedling.com',
            'role' => 'pengawas',
            'phone' => '0812-7890-1122',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $karyawan1 = User::create([
            'name' => 'Dedy Dzulkarnain',
            'username' => 'karyawan',
            'email' => 'karyawan@hellyseedling.com',
            'role' => 'karyawan',
            'phone' => '0821-3456-7890',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $karyawan2 = User::create([
            'name' => 'Ahmad Santoso (Teknisi Semai)',
            'username' => 'ahmad',
            'email' => 'ahmad@hellyseedling.com',
            'role' => 'karyawan',
            'phone' => '0853-9988-7766',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        // 2. Data Petak Semai (Nursery Plots Helly Seedling)
        $petaks = [
            [
                'kode_petak' => 'PTK-A01',
                'nama_petak' => 'Bedengan A1 (Greenhouse 1)',
                'lokasi_blok' => 'Greenhouse Barat',
                'jenis_cabai' => 'Cabai Rawit Merah (Ori 212)',
                'kapasitas_bibit' => 5000,
                'jumlah_bibit_aktif' => 4950,
                'tanggal_semai' => now()->subDays(14)->toDateString(),
                'status_kesehatan' => 'sehat',
                'catatan' => 'Pertumbuhan seragam, penyiraman otomatis pagi dan sore lancar.',
            ],
            [
                'kode_petak' => 'PTK-A02',
                'nama_petak' => 'Bedengan A2 (Greenhouse 1)',
                'lokasi_blok' => 'Greenhouse Barat',
                'jenis_cabai' => 'Cabai Rawit Merah (Asmoro)',
                'kapasitas_bibit' => 5000,
                'jumlah_bibit_aktif' => 4700,
                'tanggal_semai' => now()->subDays(18)->toDateString(),
                'status_kesehatan' => 'waspada',
                'catatan' => 'Ditemukan beberapa bibit terkulai di pojok bedengan dekat talang air.',
            ],
            [
                'kode_petak' => 'PTK-B01',
                'nama_petak' => 'Bedengan B1 (Greenhouse 2)',
                'lokasi_blok' => 'Greenhouse Timur',
                'jenis_cabai' => 'Cabai Keriting Unggul (Castilo)',
                'kapasitas_bibit' => 4500,
                'jumlah_bibit_aktif' => 4200,
                'tanggal_semai' => now()->subDays(10)->toDateString(),
                'status_kesehatan' => 'terinfeksi',
                'catatan' => 'Indikasi rebah semai meluas, kelembapan bedengan sempat terlalu tinggi.',
            ],
            [
                'kode_petak' => 'PTK-B02',
                'nama_petak' => 'Bedengan B2 (Greenhouse 2)',
                'lokasi_blok' => 'Greenhouse Timur',
                'jenis_cabai' => 'Cabai Keriting Unggul (Lado F1)',
                'kapasitas_bibit' => 4500,
                'jumlah_bibit_aktif' => 4450,
                'tanggal_semai' => now()->subDays(8)->toDateString(),
                'status_kesehatan' => 'sehat',
                'catatan' => 'Kondisi bibit kokoh, daun hijau segar, bebas hama kutu kebul.',
            ],
            [
                'kode_petak' => 'PTK-C01',
                'nama_petak' => 'Bedengan C1 (Greenhouse 3)',
                'lokasi_blok' => 'Greenhouse Selatan',
                'jenis_cabai' => 'Cabai Merah Besar (Gada MK)',
                'kapasitas_bibit' => 6000,
                'jumlah_bibit_aktif' => 5800,
                'tanggal_semai' => now()->subDays(22)->toDateString(),
                'status_kesehatan' => 'sehat',
                'catatan' => 'Siap dipindahkan ke polybag besar / distribusi ke petani mitra.',
            ],
            [
                'kode_petak' => 'PTK-C02',
                'nama_petak' => 'Bedengan C2 (Greenhouse 3)',
                'lokasi_blok' => 'Greenhouse Selatan',
                'jenis_cabai' => 'Cabai Rawit Putih (Bara)',
                'kapasitas_bibit' => 6000,
                'jumlah_bibit_aktif' => 0,
                'tanggal_semai' => now()->toDateString(),
                'status_kesehatan' => 'kosong',
                'catatan' => 'Tahap sterilisasi media tanah dan penaburan dolomit pra-semai.',
            ],
        ];

        foreach ($petaks as $p) {
            Petak::create($p);
        }

        // 3. Data Master Penyakit Bibit Cabai
        $penyakits = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Rebah Semai (Damping Off)',
                'nama_latin' => 'Pythium debaryanum / Rhizoctonia solani',
                'penyebab' => 'Cendawan tular tanah (soil-borne fungi)',
                'deskripsi' => 'Penyakit mematikan pada fase bibit muda (umur 1-15 hari). Jamur menyerang pangkal batang yang kontak langsung dengan permukaan tanah semai.',
                'faktor_pemicu' => 'Media semai terlalu basah, drainase nampan/bedengan buruk, sirkulasi udara lembab, dan naungan terlalu gelap.',
                'solusi_penanganan' => "1. Cabut dan musnahkan bibit yang roboh agar spora tidak menyebar ke bibit sehat sekitarnya.\n2. Kurangi frekuensi penyiraman dan buka sungkup plastik semai agar udara bersirkulasi.\n3. Kocor pangkal bibit di sekitar area infeksi dengan fungisida berbahan aktif Propamokarb hidroklorida atau Mankozeb dengan dosis 1.5 - 2 gr/liter air.\n4. Taburkan agens hayati Trichoderma harzianum pada media semai.",
                'tindakan_pencegahan' => 'Sterilisasi media tanah semai dengan uap panas atau penjemuran matahari terik; gunakan benih bersertifikat yang telah diberi perlakuan fungisida.',
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'Antraknosa Semai (Patek Bibit)',
                'nama_latin' => 'Colletotrichum capsici / Gloeosporioides',
                'penyebab' => 'Cendawan Colletotrichum',
                'deskripsi' => 'Menyerang batang bibit dan helai daun muda, menimbulkan bercak melekuk ke dalam berwarna coklat kehitaman yang memicu mati pucuk.',
                'faktor_pemicu' => 'Percikan air saat penyiraman kencang, kelembapan udara di atas 90%, dan kerapatan bibit yang terlalu padat.',
                'solusi_penanganan' => "1. Potong bagian pucuk atau helai daun yang berbercak hitam dengan gunting steril.\n2. Semprotkan fungisida kontak dan sistemik secara bergantian (misal: Mankozeb selang-seling dengan Difenokonazol dosis 1 ml/L).\n3. Kurangi penyiraman pada sore hari untuk mencegah daun basah sepanjang malam.",
                'tindakan_pencegahan' => 'Jaga jarak antar tray semai dan hindari menyiram bibit dengan tekanan air kasar.',
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Layu Bakteri Semai',
                'nama_latin' => 'Ralstonia solanacearum',
                'penyebab' => 'Bakteri patogen tanah Ralstonia',
                'deskripsi' => 'Bibit tampak layu tiba-tiba secara menyeluruh meskipun daun masih berwarna hijau segar dan media tanah cukup basah. Sering terjadi kematian mendadak.',
                'faktor_pemicu' => 'Suhu tanah tinggi dibarengi kelembapan tinggi, luka pada akar semai akibat gigitan nematoda atau saat pemindahan.',
                'solusi_penanganan' => "1. Segera isolasi dan buang bibit terinfeksi bersama media tanamnya ke dalam kantong tertutup.\n2. Kocor area sekitar petak dengan bakterisida berbahan aktif Streptomisin sulfat atau Oksitetrasiklin (dosis 1 gr/L air).\n3. Berikan bakteri antagonis Pseudomonas fluorescens untuk menekan populasi bakteri patogen di media semai.",
                'tindakan_pencegahan' => 'Pastikan menggunakan air siraman yang bersih (bukan air genangan tanah) dan media semai steril.',
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Bercak Daun Cercospora',
                'nama_latin' => 'Cercospora capsici',
                'penyebab' => 'Jamur Cercospora',
                'deskripsi' => 'Muncul bercak kecil bulat dengan bagian tengah berwarna abu-abu/putih dan tepian coklat gelap menyerupai mata katak. Menyebabkan daun semai rontok dini.',
                'faktor_pemicu' => 'Embun malam yang lama mengendap di permukaan daun dan naungan persemaian yang terlalu rimbun.',
                'solusi_penanganan' => "1. Buang helai daun bawah yang berbercak agar jamur tidak menular ke daun atas.\n2. Semprotkan fungisida berbahan aktif Tembaga Hidroksida atau Klorotalonil dosis 1.5 gr/L air pada pagi hari setelah embun kering.\n3. Perbaiki ventilasi udara di dalam rumah semai.",
                'tindakan_pencegahan' => 'Atur intensitas cahaya matahari pagi masuk ke persemaian dengan membuka paranet secara bertahap.',
            ],
            [
                'kode_penyakit' => 'P05',
                'nama_penyakit' => 'Penyakit Virus Kuning (Gemini Virus)',
                'nama_latin' => 'Pepper Yellow Leaf Curl Virus (Begomovirus)',
                'penyebab' => 'Virus ditularkan oleh vektor Kutu Kebul (Bemisia tabaci)',
                'deskripsi' => 'Urat daun bibit menguning cerah, helai daun mengeriting ke atas, menebal, kaku, dan tanaman mengalami stunting kerdil permanen.',
                'faktor_pemicu' => 'Populasi kutu kebul putih berterbangan di dalam rumah semai tanpa adanya jaring insect net yang rapat.',
                'solusi_penanganan' => "1. Bibit yang terbukti bergejala virus kuning harus segera dicabut dan dibakar karena tidak dapat disembuhkan dengan pestisida.\n2. Kendalikan serangga vektor (Kutu Kebul) dengan menyemprotkan insektisida bahan aktif Imidakloprid atau Abamektin dosis 0.5 - 1 ml/L.\n3. Pasang perangkap lekat kuning (Yellow Sticky Trap) di atas bedengan bibit.",
                'tindakan_pencegahan' => 'Gunakan rumah semai tertutup screen net minimal 40-50 mesh dan semprotkan ekstrak nabati pengusir hama.',
            ],
            [
                'kode_penyakit' => 'P06',
                'nama_penyakit' => 'Layu Fusarium Semai',
                'nama_latin' => 'Fusarium oxysporum f. sp. capsici',
                'penyebab' => 'Jamur patogen vaskular tanah',
                'deskripsi' => 'Bibit layu perlahan diawali dari daun bagian bawah yang menguning, tulang daun pucat, dan batang bagian dalam (berkas pembuluh) tampak berwarna coklat jika dibelah.',
                'faktor_pemicu' => 'Tanah media semai memiliki pH terlalu asam (< 5.5) dan kelembapan drainase tidak merata.',
                'solusi_penanganan' => "1. Tingkatkan pH media tanah dengan menaburkan kapur dolomit halus.\n2. Kocor pangkal bibit dengan fungisida sistemik berbahan aktif Benomil atau Karbendazim dosis 1 - 2 gr/L air.\n3. Inokulasi media bibit dengan jamur antagonis Gliocladium sp. atau Trichoderma.",
                'tindakan_pencegahan' => 'Pemberian pupuk kandang matang/kompos steril yang sudah terfermentasi sempurna pada campuran media bibit.',
            ],
        ];

        foreach ($penyakits as $peny) {
            Penyakit::create($peny);
        }

        // 4. Data Master Gejala Bibit Cabai
        $gejalas = [
            [
                'kode_gejala' => 'G01',
                'nama_gejala' => 'Batang bibit di dekat pangkal tanah melunak, menciut, dan roboh/rebah',
                'kategori_bagian' => 'batang',
                'deskripsi' => 'Pangkal batang tampak basah membusuk berair sehingga bibit tidak sanggup berdiri tegak.',
                'pertanyaan_diagnosa' => 'Apakah batang bibit bagian bawah terlihat menciut/rebah ke tanah?',
            ],
            [
                'kode_gejala' => 'G02',
                'nama_gejala' => 'Muncul lapisan benang jamur (hifa) putih halus di pangkal batang semai',
                'kategori_bagian' => 'batang',
                'deskripsi' => 'Terdapat serabut halus seperti kapas pada permukaan tanah di sekeliling batang bibit.',
                'pertanyaan_diagnosa' => 'Apakah ada lapisan jamur putih halus di sekitar pangkal bibit?',
            ],
            [
                'kode_gejala' => 'G03',
                'nama_gejala' => 'Bibit layu mendadak saat media tanam masih dalam kondisi basah/lembab',
                'kategori_bagian' => 'bibit_umum',
                'deskripsi' => 'Seluruh daun bibit terkulai lemas meskipun tanah semai tidak kekurangan air.',
                'pertanyaan_diagnosa' => 'Apakah bibit tiba-tiba layu lemas padahal media semai masih basah?',
            ],
            [
                'kode_gejala' => 'G04',
                'nama_gejala' => 'Bercak coklat kehitaman melekuk ke dalam pada batang bibit',
                'kategori_bagian' => 'batang',
                'deskripsi' => 'Luka nekrotik pada batang yang bentuknya melekuk/cekung ke dalam.',
                'pertanyaan_diagnosa' => 'Apakah terdapat bercak cekung menghitam pada batang bibit?',
            ],
            [
                'kode_gejala' => 'G05',
                'nama_gejala' => 'Pucuk bibit menghitam, mengering, dan mati pucuk (dieback)',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Kuncup daun termuda mengering dari ujung menjalar ke bawah.',
                'pertanyaan_diagnosa' => 'Apakah pucuk daun teratas menghitam dan kering mati pucuk?',
            ],
            [
                'kode_gejala' => 'G06',
                'nama_gejala' => 'Urat daun menguning cerah kontras dengan warna daun',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Gejala vein clearing di mana jala tulang daun berwarna kuning terang.',
                'pertanyaan_diagnosa' => 'Apakah tulang-tulang daun bibit berwarna kuning cerah mencolok?',
            ],
            [
                'kode_gejala' => 'G07',
                'nama_gejala' => 'Daun menggulung/mengeriting kaku dan helaian daun menebal',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Helai daun melengkung ke atas atau ke bawah menyerupai mangkok dan tekstur kaku.',
                'pertanyaan_diagnosa' => 'Apakah daun bibit mengeriting melengkung kaku dan menebal?',
            ],
            [
                'kode_gejala' => 'G08',
                'nama_gejala' => 'Bibit mengalami stunting (tumbuh sangat kerdil dibanding normal)',
                'kategori_bagian' => 'bibit_umum',
                'deskripsi' => 'Ruas batang bibit memendek drastis, tidak kunjung bertambah tinggi.',
                'pertanyaan_diagnosa' => 'Apakah pertumbuhan bibit terhambat dan jauh lebih kerdil dari bibit lainnya?',
            ],
            [
                'kode_gejala' => 'G09',
                'nama_gejala' => 'Bercak bulat konsentris kecil tepi coklat gelap (bercak mata katak)',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Bercak bulat dengan pusat bercak berwarna abu-abu muda bertepi coklat pekat.',
                'pertanyaan_diagnosa' => 'Apakah daun memiliki bercak bulat dengan pusat abu-abu bertepi coklat?',
            ],
            [
                'kode_gejala' => 'G10',
                'nama_gejala' => 'Daun semai mudah sobek/berlubang pada pusat bercak lalu rontok',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Bagian tengah bercak daun rapuh dan bolong, lalu helai daun gugur sebelum waktunya.',
                'pertanyaan_diagnosa' => 'Apakah daun mudah berlubang pada bercaknya dan berguguran?',
            ],
            [
                'kode_gejala' => 'G11',
                'nama_gejala' => 'Bibit layu pada siang terik namun segar kembali pada pagi/malam hari',
                'kategori_bagian' => 'bibit_umum',
                'deskripsi' => 'Layu sementara (reversible wilting) di awal fase infeksi pembuluh tanaman.',
                'pertanyaan_diagnosa' => 'Apakah bibit layu hanya saat terik matahari dan segar kembali saat dingin?',
            ],
            [
                'kode_gejala' => 'G12',
                'nama_gejala' => 'Akar bibit membusuk dan berwarna coklat kehitaman saat dicabut',
                'kategori_bagian' => 'akar',
                'deskripsi' => 'Sistem perakaran tidak berkembang, ujung akar kecoklatan dan rapuh mudah putus.',
                'pertanyaan_diagnosa' => 'Apakah akar bibit tampak busuk kecoklatan saat diperiksa/dicabut?',
            ],
            [
                'kode_gejala' => 'G13',
                'nama_gejala' => 'Berkas pembuluh batang berwarna coklat kemerahan saat dibelah',
                'kategori_bagian' => 'batang',
                'deskripsi' => 'Jaringan vaskular xilem di dalam batang mengalami pencoklatan akibat sumbatan jamur.',
                'pertanyaan_diagnosa' => 'Apakah bagian dalam batang berwarna coklat kemerahan saat dibelah membujur?',
            ],
            [
                'kode_gejala' => 'G14',
                'nama_gejala' => 'Keluar cairan lendir putih keruh saat pangkal batang direndam air (Uji Ooze)',
                'kategori_bagian' => 'batang',
                'deskripsi' => 'Bacterial ooze khas pada infeksi Ralstonia saat pangkal batang dipotong dan dimasukkan air bening.',
                'pertanyaan_diagnosa' => 'Apakah keluar lendir asap putih saat potongan batang direndam di air bersih?',
            ],
            [
                'kode_gejala' => 'G15',
                'nama_gejala' => 'Daun bawah menguning perlahan dan menjalar ke atas secara bertahap',
                'kategori_bagian' => 'daun',
                'deskripsi' => 'Klorosis bertahap dimulai dari daun tua terbawah kemudian mengering bertahap.',
                'pertanyaan_diagnosa' => 'Apakah daun bagian paling bawah menguning perlahan naik ke daun atas?',
            ],
        ];

        foreach ($gejalas as $gej) {
            Gejala::create($gej);
        }

        // 5. Basis Aturan & Nilai Certainty Factor Pakar (Bpk. Ino & Helly Sumanto)
        $rules = [
            // P01: Rebah Semai (Damping Off)
            ['penyakit' => 'P01', 'gejala' => 'G01', 'bobot' => 0.95],
            ['penyakit' => 'P01', 'gejala' => 'G02', 'bobot' => 0.85],
            ['penyakit' => 'P01', 'gejala' => 'G03', 'bobot' => 0.70],
            ['penyakit' => 'P01', 'gejala' => 'G12', 'bobot' => 0.80],

            // P02: Antraknosa Semai (Patek)
            ['penyakit' => 'P02', 'gejala' => 'G04', 'bobot' => 0.90],
            ['penyakit' => 'P02', 'gejala' => 'G05', 'bobot' => 0.85],
            ['penyakit' => 'P02', 'gejala' => 'G07', 'bobot' => 0.60],
            ['penyakit' => 'P02', 'gejala' => 'G10', 'bobot' => 0.75],

            // P03: Layu Bakteri Semai
            ['penyakit' => 'P03', 'gejala' => 'G03', 'bobot' => 0.85],
            ['penyakit' => 'P03', 'gejala' => 'G11', 'bobot' => 0.75],
            ['penyakit' => 'P03', 'gejala' => 'G14', 'bobot' => 0.95],
            ['penyakit' => 'P03', 'gejala' => 'G12', 'bobot' => 0.70],

            // P04: Bercak Daun Cercospora
            ['penyakit' => 'P04', 'gejala' => 'G09', 'bobot' => 0.90],
            ['penyakit' => 'P04', 'gejala' => 'G10', 'bobot' => 0.80],
            ['penyakit' => 'P04', 'gejala' => 'G06', 'bobot' => 0.60],

            // P05: Virus Kuning (Gemini)
            ['penyakit' => 'P05', 'gejala' => 'G06', 'bobot' => 0.90],
            ['penyakit' => 'P05', 'gejala' => 'G07', 'bobot' => 0.85],
            ['penyakit' => 'P05', 'gejala' => 'G08', 'bobot' => 0.95],

            // P06: Layu Fusarium
            ['penyakit' => 'P06', 'gejala' => 'G03', 'bobot' => 0.70],
            ['penyakit' => 'P06', 'gejala' => 'G11', 'bobot' => 0.85],
            ['penyakit' => 'P06', 'gejala' => 'G12', 'bobot' => 0.80],
            ['penyakit' => 'P06', 'gejala' => 'G13', 'bobot' => 0.90],
            ['penyakit' => 'P06', 'gejala' => 'G15', 'bobot' => 0.80],
        ];

        foreach ($rules as $r) {
            $p = Penyakit::where('kode_penyakit', $r['penyakit'])->first();
            $g = Gejala::where('kode_gejala', $r['gejala'])->first();
            if ($p && $g) {
                Rule::create([
                    'penyakit_id' => $p->id,
                    'gejala_id' => $g->id,
                    'bobot_pakar' => $r['bobot'],
                ]);
            }
        }

        // 6. Data Riwayat Diagnosa Awal & Tindakan (Live Demo Multi-Penyakit & Tren)
        $cfService = new \App\Services\CertaintyFactorService();
        $gejalaByKode = Gejala::all()->keyBy('kode_gejala');
        $petakByKode = Petak::all()->keyBy('kode_petak');

        $sampleCases = [
            [
                'kode' => 'DG-20261101-001',
                'user' => $karyawan1,
                'petak' => $petakByKode['PTK-A01'],
                'gejalas' => ['G09' => 0.8, 'G10' => 0.6],
                'status' => 'selesai',
                'catatan' => 'Bercak bulat mata katak pada daun bawah dekat talang air.',
                'days_ago' => 11,
            ],
            [
                'kode' => 'DG-20261103-002',
                'user' => $karyawan2,
                'petak' => $petakByKode['PTK-B02'],
                'gejalas' => ['G06' => 0.8, 'G07' => 0.8, 'G08' => 1.0],
                'status' => 'selesai',
                'catatan' => 'Ditemukan 6 bibit kerdil daun kuning melengkung akibat kutu kebul.',
                'days_ago' => 9,
            ],
            [
                'kode' => 'DG-20261106-003',
                'user' => $karyawan1,
                'petak' => $petakByKode['PTK-C01'],
                'gejalas' => ['G04' => 1.0, 'G05' => 0.8, 'G10' => 0.6],
                'status' => 'selesai',
                'catatan' => 'Pucuk beberapa bibit cabai besar menghitam setelah hujan sore.',
                'days_ago' => 6,
            ],
            [
                'kode' => 'DG-20261108-004',
                'user' => $karyawan2,
                'petak' => $petakByKode['PTK-A02'],
                'gejalas' => ['G03' => 0.8, 'G11' => 0.8, 'G14' => 1.0],
                'status' => 'diproses',
                'catatan' => 'Bibit layu mendadak padahal media basah, uji celup air keluar lendir putih.',
                'days_ago' => 4,
            ],
            [
                'kode' => 'DG-20261110-005',
                'user' => $karyawan1,
                'petak' => $petakByKode['PTK-B01'],
                'gejalas' => ['G11' => 0.8, 'G13' => 0.8, 'G15' => 0.8],
                'status' => 'selesai',
                'catatan' => 'Daun bawah menguning bertahap, pembuluh batang tampak kecoklatan.',
                'days_ago' => 2,
            ],
            [
                'kode' => 'DG-20261112-006',
                'user' => $karyawan1,
                'petak' => $petakByKode['PTK-B01'],
                'gejalas' => ['G01' => 1.0, 'G02' => 0.8, 'G12' => 0.8],
                'status' => 'diproses',
                'catatan' => 'Ditemukan sekitar 25 bibit di nampan 3 roboh lemas pada pagi hari.',
                'days_ago' => 0,
            ],
        ];

        $weightLabels = [
            '1.00' => 'Sangat Yakin (1.0)',
            '0.80' => 'Yakin (0.8)',
            '0.60' => 'Cukup Yakin (0.6)',
            '0.40' => 'Sedikit Ragu (0.4)',
        ];

        $lastDiag = null;
        foreach ($sampleCases as $case) {
            $symptomMap = [];
            foreach ($case['gejalas'] as $gKode => $w) {
                $symptomMap[$gejalaByKode[$gKode]->id] = $w;
            }
            $res = $cfService->diagnose($symptomMap);
            $best = $res['best_disease'];
            $timestamp = now()->subDays($case['days_ago']);

            $diag = Diagnosa::create([
                'kode_diagnosa' => $case['kode'],
                'user_id' => $case['user']->id,
                'petak_id' => $case['petak']->id,
                'penyakit_terpilih_id' => $best['penyakit_id'],
                'nilai_cf_akhir' => $best['cf_final'],
                'persentase_cf' => $best['persentase'],
                'tingkat_keyakinan' => $best['confidence_level'],
                'hasil_semua_penyakit_json' => $res['ranked_diseases'],
                'status_tindakan' => $case['status'],
                'catatan_karyawan' => $case['catatan'],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            foreach ($symptomMap as $gId => $w) {
                $fmt = number_format($w, 2);
                DiagnosaDetail::create([
                    'diagnosa_id' => $diag->id,
                    'gejala_id' => $gId,
                    'nilai_keyakinan_user' => $w,
                    'keterangan_user' => $weightLabels[$fmt] ?? "Keyakinan ({$w})",
                ]);
            }

            $lastDiag = $diag;
        }

        if ($lastDiag) {
            Tindakan::create([
                'diagnosa_id' => $lastDiag->id,
                'petak_id' => $petakByKode['PTK-B01']->id,
                'pengawas_id' => $pengawas->id,
                'karyawan_id' => $karyawan1->id,
                'instruksi_tindakan' => 'Segera cabut nampan semai yang roboh. Kocor fungisida Propamokarb dan kurangi siram sore.',
                'rekomendasi_pestisida' => 'Fungisida Previcur N / Propamokarb Hidroklorida',
                'dosis_aplikasi' => '1.5 ml / Liter air',
                'status' => 'sedang_dikerjakan',
                'tanggal_pelaksanaan' => now()->toDateString(),
                'catatan_pelaksanaan' => 'Sudah dicabut 28 bibit terinfeksi, penyemprotan area bedengan telah dimulai.',
            ]);
        }
    }
}

