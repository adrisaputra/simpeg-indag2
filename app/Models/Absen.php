<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    // use HasFactory;
	protected $table = 'absen_tbl';
	protected $fillable =[
        'pegawai_id',
        'nip',
        'nama_pegawai',
        'bidang_id',
        'jabatan_id',
        'kehadiran',
        'keterangan',
        'jam_datang',
        'jam_pulang',
        'tanggal',
        'user_id'
    ];
    
}
