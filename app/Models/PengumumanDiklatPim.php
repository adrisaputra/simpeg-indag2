<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanDiklatPim extends Model
{
    // use HasFactory;
	protected $table = 'pengumuman_diklat_pim_tbl';
	protected $fillable =[
        'judul',
        'penyelenggara',
        'bidang',
        'syarat',
        'tanggal_mulai',
        'tanggal_selesai',
        'user_id'
    ];
}
