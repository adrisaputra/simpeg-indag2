<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
     // use HasFactory;
	protected $table = 'notulen_tbl';
	protected $fillable =[
        'agenda',
        'pimpinan',
        'anggota',
        'tanggal',
        'file_notulen',
        'user_id'
    ];
}
