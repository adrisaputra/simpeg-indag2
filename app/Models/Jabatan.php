<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    // use HasFactory;
	protected $table = 'jabatan_tbl';
	protected $fillable =[
        'nama_jabatan',
        'user_id'
    ];

    
    public function pegawai()
    {
        return $this->hasOne('App\Models\Pegawai');
    }

    public function relasibidang()
    {
        return $this->hasOne('App\Models\RelasiBidang');
    }
    
}
