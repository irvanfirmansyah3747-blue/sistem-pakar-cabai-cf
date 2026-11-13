<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'nama_latin',
        'penyebab',
        'deskripsi',
        'faktor_pemicu',
        'solusi_penanganan',
        'tindakan_pencegahan',
        'gambar',
    ];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'rules')
                    ->withPivot('bobot_pakar')
                    ->withTimestamps();
    }

    public function diagnosas()
    {
        return $this->hasMany(Diagnosa::class, 'penyakit_terpilih_id');
    }
}

