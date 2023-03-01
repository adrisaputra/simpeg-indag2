<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatCuti extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_cuti_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_cuti',
        'keterangan',
        'mulai',
        'selesai',
        'no_sk',
        'tanggal_sk',
        'arsip_cuti',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
