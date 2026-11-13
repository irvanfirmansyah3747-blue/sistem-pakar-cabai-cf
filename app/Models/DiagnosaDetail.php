<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosaDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosa_id',
        'gejala_id',
        'nilai_keyakinan_user',
        'keterangan_user',
    ];

    protected $casts = [
        'nilai_keyakinan_user' => 'float',
    ];

    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}

