<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    // use HasFactory;
	protected $table = 'pegawai_tbl';
	protected $fillable =[
        'nip',
        'nama_pegawai',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'gol_darah',
        'email',
        'no_ktp',
        'ktp',
        'no_bpjs',
        'bpjs',
        'no_npwp',
        'npwp',
        'no_karpeg',
        'karpeg',
        'karsu',
        'no_karsu',
        'no_taspen',
        'taspen',
        'foto_formal',
        'foto_kedinasan',
        'tmt',
        'golongan',
        'pendidikan',
        'esselon',
        'kgb_saat_ini',
        'jabatan_id',
        'bidang_id',
        'seksi_id',
        'status',
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

    public function seksi()
    {
        return $this->belongsTo('App\Models\Seksi');
    }

    public function riwayatayah()
    {
        return $this->hasOne('App\Models\RiwayatAyah');
    }
    
    public function riwayatibu()
    {
        return $this->hasOne('App\Models\RiwayatIbu');
    }
    
    public function riwayatpasangan()
    {
        return $this->hasOne('App\Models\RiwayatPasangan');
    }
    
    public function riwayatanak()
    {
        return $this->hasOne('App\Models\RiwayatAnak');
    }
    
    public function pelaksanaevent()
    {
        return $this->hasOne('App\Models\PelaksanaEvent');
    }
    
}
