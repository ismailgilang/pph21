<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penggajian extends Model
{
    protected $fillable = [
        'karyawan_id',
        'kegiatan',
        'tanggal',
        'diajukan',
        'dpp',
        'pph21',
        'dibayarkan'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
