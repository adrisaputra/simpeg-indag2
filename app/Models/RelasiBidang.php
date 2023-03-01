<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiBidang extends Model
{
    // use HasFactory;
	protected $table = 'relasi_bidang_tbl';
	protected $fillable =[
        'jabatan_id',
        'bidang_id',
        'user_id'
    ];

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan');
    }

    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang');
    }
}
