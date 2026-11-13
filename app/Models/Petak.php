<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petak extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_petak',
        'nama_petak',
        'lokasi_blok',
        'jenis_cabai',
        'kapasitas_bibit',
        'jumlah_bibit_aktif',
        'tanggal_semai',
        'status_kesehatan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_semai' => 'date',
    ];

    public function diagnosas()
    {
        return $this->hasMany(Diagnosa::class);
    }

    public function tindakans()
    {
        return $this->hasMany(Tindakan::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status_kesehatan) {
            'sehat' => ['label' => 'Sehat', 'color' => 'emerald', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'waspada' => ['label' => 'Waspada', 'color' => 'amber', 'bg' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'terinfeksi' => ['label' => 'Terinfeksi', 'color' => 'rose', 'bg' => 'bg-rose-100 text-rose-800 border-rose-300'],
            'kosong' => ['label' => 'Kosong / Istirahat', 'color' => 'slate', 'bg' => 'bg-slate-100 text-slate-700 border-slate-300'],
            default => ['label' => ucfirst($this->status_kesehatan), 'color' => 'slate', 'bg' => 'bg-slate-100 text-slate-700 border-slate-300'],
        };
    }
}

