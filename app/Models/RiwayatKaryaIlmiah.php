<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKaryaIlmiah extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_karya_ilmiah_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_buku',
        'judul_buku',
        'jenis_kegiatan',
        'peranan',
        'tahun',
        'arsip_karya_ilmiah',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
