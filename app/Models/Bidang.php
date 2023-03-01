<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    // use HasFactory;
	protected $table = 'bidang_tbl';
	protected $fillable =[
        'jabatan_id',
        'nama_bidang',
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
