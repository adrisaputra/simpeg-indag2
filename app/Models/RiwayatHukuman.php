<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatHukuman extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_hukuman_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_hukuman',
        'mulai',
        'selesai',
        'no_sk',
        'tanggal_sk',
        'pejabat',
        'keterangan',
        'arsip_hukuman',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
