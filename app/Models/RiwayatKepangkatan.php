<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKepangkatan extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_kepangkatan_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_golongan',
        'periode_kp',
        'periode_kp_sebelumnya',
        'periode_kp_saat_ini',
        'golongan',
        'nama_pangkat',
        'tmt',
        'mk_tahun',
        'mk_bulan',
        'no_sk',
        'tanggal_sk',
        'pejabat',
        'arsip_kepangkatan',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
