<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDiklat extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_diklat_tbl';
	protected $fillable =[
        'pegawai_id',
        'kelompok_diklat',
        'jenis_diklat',
        'nama_diklat',
        'negara',
        'lokasi',
        'kota',
        'tmt_mulai',
        'tmt_selesai',
        'hari',
        'jam',
        'kualitas',
        'arsip_diklat',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
