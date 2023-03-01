<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatOrangTua extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_orang_tua_tbl';
	protected $fillable =[
        'pegawai_id',
        'orang_tua',
        'nama_orang_tua',
        'tanggal_lahir',
        'pekerjaan',
        'kartu_keluarga',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }

}
