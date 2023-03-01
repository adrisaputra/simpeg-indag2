<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatIbu extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_ibu_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_ibu',
        'tempat_lahir',
        'tanggal_lahir',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
