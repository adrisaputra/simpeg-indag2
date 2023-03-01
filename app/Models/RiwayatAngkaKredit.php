<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAngkaKredit extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_angka_kredit_tbl';
	protected $fillable =[
        'pegawai_id',
        'jabatan',
        'no_pak',
        'tanggal_pak',
        'pendidikan',
        'pelaksanaan_tupok',
        'pengembangan_profesi',
        'unsur_penunjang',
        'jumlah',
        'tmt_angka_kredit',
        'sk',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
