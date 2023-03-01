<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Honorer extends Model
{
    // use HasFactory;
	protected $table = 'honorer_tbl';
	protected $fillable =[
        'nama_pegawai',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'gol_darah',
        'email',
        'pendidikan',
        'sk_honorer',
        'user_id'
    ];
}
