<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_jabatan_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_jabatan',
        'status_mutasi_instansi',
        'tipe_jabatan',
        'jenjang',
        'status_mutasi_pegawai',
        'jabatan',
        'status',
        'instansi_asal',
        'tmt_mulai',
        'tmt_selesai',
        'no_sk',
        'tanggal_sk',
        'tunjangan',
        'esselon',
        'keterangan',
        'arsip_jabatan',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
