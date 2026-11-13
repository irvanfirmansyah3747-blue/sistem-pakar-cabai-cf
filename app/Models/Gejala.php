<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'kategori_bagian',
        'deskripsi',
        'pertanyaan_diagnosa',
    ];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function penyakits()
    {
        return $this->belongsToMany(Penyakit::class, 'rules')
                    ->withPivot('bobot_pakar')
                    ->withTimestamps();
    }

    public function diagnosaDetails()
    {
        return $this->hasMany(DiagnosaDetail::class);
    }

    public function getKategoriBadgeAttribute()
    {
        return match ($this->kategori_bagian) {
            'daun' => ['label' => 'Daun', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            'batang' => ['label' => 'Batang', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
            'akar' => ['label' => 'Akar', 'class' => 'bg-stone-50 text-stone-700 border-stone-200'],
            default => ['label' => 'Bibit Umum', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
        };
    }
}

