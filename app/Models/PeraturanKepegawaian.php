<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeraturanKepegawaian extends Model
{
     // use HasFactory;
	protected $table = 'peraturan_kepegawaian_tbl';
	protected $fillable =[
        'judul',
        'isi',
        'user_id'
    ];
}
