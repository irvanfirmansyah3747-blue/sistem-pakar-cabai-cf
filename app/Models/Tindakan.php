<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosa_id',
        'petak_id',
        'pengawas_id',
        'karyawan_id',
        'instruksi_tindakan',
        'rekomendasi_pestisida',
        'dosis_aplikasi',
        'status',
        'tanggal_pelaksanaan',
        'catatan_pelaksanaan',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class);
    }

    public function petak()
    {
        return $this->belongsTo(Petak::class);
    }

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'menunggu' => ['label' => 'Menunggu Dikerjakan', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'sedang_dikerjakan' => ['label' => 'Sedang Berjalan', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'selesai' => ['label' => 'Selesai & Pulih', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            default => ['label' => ucfirst($this->status), 'class' => 'bg-slate-100 text-slate-800 border-slate-300'],
        };
    }
}

