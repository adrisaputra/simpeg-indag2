<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPajak extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_pajak_tbl';
	protected $fillable =[
        'pegawai_id',
        'no_npwp',
        'jenis_spt',
        'tahun',
        'pembetulan',
        'status',
        'jumlah',
        'arsip_spt',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
