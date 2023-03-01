<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatLhkpn extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_lhkpn_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_lhkpn',
        'tanggal_lapor',
        'jenis_pelaporan',
        'jabatan',
        'status_laporan',
        'arsip_lhkpn',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
