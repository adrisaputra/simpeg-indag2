<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'title', 'start', 'end', 'end2','bidang','uraian'
    ];
}
