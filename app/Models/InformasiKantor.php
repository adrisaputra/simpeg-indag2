<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiKantor extends Model
{
     // use HasFactory;
	protected $table = 'informasi_kantor_tbl';
	protected $fillable =[
        'judul',
        'isi',
        'user_id'
    ];
}
