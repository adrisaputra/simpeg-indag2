<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTugas extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_tugas_tbl';
	protected $fillable =[
        'pegawai_id',
        'keterangan',
        'tingkat',
        'negara',
        'provinsi',
        'fakultas',
        'jurusan',
        'tmt_mulai',
        'tmt_selesai',
        'no_surat',
        'tanggal_izin',
        'arsip_tugas',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
