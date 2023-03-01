<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAnak extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_anak_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_anak',
        'jenis_kelamin',
        'tanggal_lahir',
        'status',
        'pendidikan',
        'akta_kelahiran',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
