<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKompetensi extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_kompetensi_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_kegiatan',
        'tanggal',
        'tempat',
        'angkatan',
        'arsip_kompetensi',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
