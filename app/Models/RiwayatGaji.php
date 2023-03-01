<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatGaji extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_gaji_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_golongan',
        'golongan',
        'nama_pangkat',
        'masa_kerja',
        'tmt',
        'gaji',
        'sk_pejabat',
        'arsip_gaji',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
