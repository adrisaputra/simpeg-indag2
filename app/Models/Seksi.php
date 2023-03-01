<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    // use HasFactory;
	protected $table = 'seksi_tbl';
	protected $fillable =[
        'bidang_id',
        'nama_seksi',
        'user_id'
    ];
    
    public function pegawai()
    {
        return $this->hasOne('App\Models\Pegawai');
    }
    
}
