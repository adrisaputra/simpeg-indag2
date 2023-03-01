<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_pendidikan_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_pendidikan',
        'tingkat',
        'lembaga',
        'fakultas',
        'jurusan',
        'no_sttb',
        'tanggal_sttb',
        'tanggal_kelulusan',
        'ipk',
        'arsip_ijazah',
        'arsip_transkrip_nilai',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
