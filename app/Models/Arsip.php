<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
     // use HasFactory;
	protected $table = 'arsip_tbl';
	protected $fillable =[
        'jenis',
        'no_surat',
        'perihal',
        'disposisi',
        'tanggal',
        'file_arsip',
        'user_id'
    ];
}
