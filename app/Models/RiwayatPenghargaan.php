<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenghargaan extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_penghargaan_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_penghargaan',
        'no_sk',
        'tanggal_sk',
        'keterangan',
        'arsip_penghargaan',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
