<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKgb extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_kgb_tbl';
	protected $fillable =[
        'pegawai_id',
        'dasar',
        'gaji_lama',
        'gaji_baru',
        'kgb_terakhir',
        'kgb_saat_ini',
        'arsip_kgb',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
