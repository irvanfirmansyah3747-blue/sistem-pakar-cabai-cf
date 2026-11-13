<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_diagnosa',
        'user_id',
        'petak_id',
        'penyakit_terpilih_id',
        'nilai_cf_akhir',
        'persentase_cf',
        'tingkat_keyakinan',
        'hasil_semua_penyakit_json',
        'status_tindakan',
        'catatan_karyawan',
        'foto_bukti',
    ];

    protected $casts = [
        'nilai_cf_akhir' => 'float',
        'persentase_cf' => 'float',
        'hasil_semua_penyakit_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petak()
    {
        return $this->belongsTo(Petak::class);
    }

    public function penyakitTerpilih()
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_terpilih_id');
    }

    public function details()
    {
        return $this->hasMany(DiagnosaDetail::class);
    }

    public function tindakans()
    {
        return $this->hasMany(Tindakan::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status_tindakan) {
            'menunggu' => ['label' => 'Menunggu Tindakan', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'diproses' => ['label' => 'Sedang Diproses', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'selesai' => ['label' => 'Selesai Ditangani', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            default => ['label' => ucfirst($this->status_tindakan), 'class' => 'bg-slate-100 text-slate-800 border-slate-300'],
        };
    }
}

