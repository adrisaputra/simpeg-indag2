<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaEvent extends Model
{
    // use HasFactory;
	protected $table = 'pelaksana_event_tbl';
	protected $fillable =[
        'events_id',
        'pegawai_id',
        'user_id'
    ];

    
    public function event()
    {
        return $this->belongsTo('App\Models\Events');
    }
 
    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }

}
