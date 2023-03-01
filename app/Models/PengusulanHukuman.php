<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengusulanHukuman extends Model
{
    // use HasFactory;
	protected $table = 'pengusulan_hukuman_tbl';
	protected $fillable =[
        'nip',
        'nama_pegawai',
        'jenis',
        'alasan',
        'unit_kerja',
        'user_id'
    ];
}
