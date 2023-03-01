<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSeminar extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_seminar_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_seminar',
        'tingkat_seminar',
        'peranan',
        'tanggal',
        'penyelenggara',
        'tempat',
        'arsip_sertifikat_seminar',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
