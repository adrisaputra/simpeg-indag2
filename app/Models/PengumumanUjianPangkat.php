<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanUjianPangkat extends Model
{
    // use HasFactory;
	protected $table = 'pengumuman_ujian_pangkat_tbl';
	protected $fillable =[
        'lokasi',
        'syarat',
        'tanggal_mulai',
        'tanggal_selesai',
        'user_id'
    ];
}
