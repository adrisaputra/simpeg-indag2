<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengusulanPenghargaan extends Model
{
    // use HasFactory;
	protected $table = 'pengusulan_penghargaan_tbl';
	protected $fillable =[
        'nip',
        'nama_pegawai',
        'jenis',
        'syarat',
        'user_id'
    ];
}
