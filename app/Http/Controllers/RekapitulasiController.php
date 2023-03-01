<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKepangkatan;   //nama model
use App\Models\RiwayatCuti;   //nama model
use App\Models\Jabatan;   //nama model
use App\Models\Bidang;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class RekapitulasiController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rekapitulasi_jumlah_pegawai()
    {
        $pria = Pegawai::where('jenis_kelamin','Pria')->where('status_hapus',0)->count();
        $wanita = Pegawai::where('jenis_kelamin','Wanita')->where('status_hapus',0)->count();
        $jumlah_pegawai = Pegawai::where('status_hapus',0)->count();
        return view('admin.rekapitulasi.jumlah_pegawai',compact('pria','wanita','jumlah_pegawai'));
    }
    
    public function rekapitulasi_jumlah_pegawai_bidang()
    {
        $bidang = Bidang::get();
        
        $i=1;
        foreach($bidang as $v){
            $jumlah_pegawai_bidang[$i] = Pegawai::where('bidang_id',$v->id)->where('status_hapus',0)->count();
            $i++;
        }

        return view('admin.rekapitulasi.jumlah_pegawai_bidang',compact('bidang','jumlah_pegawai_bidang'));
    }

    public function rekapitulasi_esselon()
    {
        $bidang = Bidang::get();
        
        $i=1;
        foreach($bidang as $v){
            $jumlah_esselon[$i] = Pegawai::where('bidang_id',$v->id)->whereNotNull('esselon')->where('status_hapus',0)->count();
            $i++;
        }

        return view('admin.rekapitulasi.esselon',compact('bidang','jumlah_esselon'));
    }

    public function rekapitulasi_gender_bidang()
    {
        $bidang = Bidang::get();
        
        $i=1;
        foreach($bidang as $v){
            $pria[$i] = Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('status_hapus',0)->count();
            $wanita[$i] = Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('status_hapus',0)->count();
            $jumlah[$i] = $pria[$i]+$wanita[$i];
            $i++;
        }
        
        return view('admin.rekapitulasi.jumlah_pegawai_gender_bidang',compact('bidang','pria','wanita','jumlah'));
    }

    # Golongan
    public function rekapitulasi_golongan()
    {
        $bidang = Bidang::get();

        $i=1;
        foreach($bidang as $v){
            $jumlah_pegawai_bidang[$i] = Pegawai::where('bidang_id',$v->id)->where('status_hapus',0)->count();
            $pria[$i] = Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('status_hapus',0)->count();
            $wanita[$i] = Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('status_hapus',0)->count();

            $id = $v->id;

            $pria17[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan IV/e')->where('status_hapus',0)->count();
            $pria16[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan IV/d')->where('status_hapus',0)->count();
            $pria15[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan IV/c')->where('status_hapus',0)->count();
            $pria14[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan IV/b')->where('status_hapus',0)->count();
            $pria13[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan IV/a')->where('status_hapus',0)->count();
            $pria12[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan III/d')->where('status_hapus',0)->count();
            $pria11[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan III/c')->where('status_hapus',0)->count();
            $pria10[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan III/b')->where('status_hapus',0)->count();
            $pria9[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan III/a')->where('status_hapus',0)->count();
            $pria8[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan II/d')->where('status_hapus',0)->count();
            $pria7[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan II/c')->where('status_hapus',0)->count();
            $pria6[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan II/b')->where('status_hapus',0)->count();
            $pria5[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan II/a')->where('status_hapus',0)->count();
            $pria4[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan I/d')->where('status_hapus',0)->count();
            $pria3[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan I/c')->where('status_hapus',0)->count();
            $pria2[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan I/b')->where('status_hapus',0)->count();
            $pria1[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Pria')->where('golongan','Golongan I/a')->where('status_hapus',0)->count();

            $wanita17[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan IV/e')->where('status_hapus',0)->count();
            $wanita16[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan IV/d')->where('status_hapus',0)->count();
            $wanita15[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan IV/c')->where('status_hapus',0)->count();
            $wanita14[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan IV/b')->where('status_hapus',0)->count();
            $wanita13[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan IV/a')->where('status_hapus',0)->count();
            $wanita12[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan III/d')->where('status_hapus',0)->count();
            $wanita11[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan III/c')->where('status_hapus',0)->count();
            $wanita10[$i] =   Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan III/b')->where('status_hapus',0)->count();
            $wanita9[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan III/a')->where('status_hapus',0)->count();
            $wanita8[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan II/d')->where('status_hapus',0)->count();
            $wanita7[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan II/c')->where('status_hapus',0)->count();
            $wanita6[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan II/b')->where('status_hapus',0)->count();
            $wanita5[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan II/a')->where('status_hapus',0)->count();
            $wanita4[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan I/d')->where('status_hapus',0)->count();
            $wanita3[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan I/c')->where('status_hapus',0)->count();
            $wanita2[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan I/b')->where('status_hapus',0)->count();
            $wanita1[$i] =    Pegawai::where('bidang_id',$v->id)->where('jenis_kelamin','Wanita')->where('golongan','Golongan I/a')->where('status_hapus',0)->count();

            $total17[$i] = $pria17[$i] + $wanita17[$i];
            $total16[$i] = $pria16[$i] + $wanita16[$i];
            $total15[$i] = $pria15[$i] + $wanita15[$i];
            $total14[$i] = $pria14[$i] + $wanita14[$i];
            $total13[$i] = $pria13[$i] + $wanita13[$i];
            $total12[$i] = $pria12[$i] + $wanita12[$i];
            $total11[$i] = $pria11[$i] + $wanita11[$i];
            $total10[$i] = $pria10[$i] + $wanita10[$i];
            $total9[$i] = $pria9[$i] + $wanita9[$i];
            $total8[$i] = $pria8[$i] + $wanita8[$i];
            $total7[$i] = $pria7[$i] + $wanita7[$i];
            $total6[$i] = $pria6[$i] + $wanita6[$i];
            $total5[$i] = $pria5[$i] + $wanita5[$i];
            $total4[$i] = $pria4[$i] + $wanita4[$i];
            $total3[$i] = $pria3[$i] + $wanita3[$i];
            $total2[$i] = $pria2[$i] + $wanita2[$i];
            $total1[$i] = $pria1[$i] + $wanita1[$i];

            $jumlah_pria_gol_4[$i] = $pria17[$i] + $pria16[$i] + $pria15[$i] + $pria14[$i] + $pria13[$i];
            $jumlah_wanita_gol_4[$i] = $wanita17[$i] + $wanita16[$i] + $wanita15[$i] + $wanita14[$i] + $wanita13[$i];
            $total_semua_gol_4[$i] = $jumlah_pria_gol_4[$i] + $jumlah_wanita_gol_4[$i];

            $jumlah_pria_gol_3[$i] = $pria12[$i] + $pria11[$i] + $pria10[$i] + $pria9[$i];
            $jumlah_wanita_gol_3[$i] = $wanita12[$i] + $wanita11[$i] + $wanita10[$i] + $wanita9[$i];
            $total_semua_gol_3[$i] = $jumlah_pria_gol_3[$i] + $jumlah_wanita_gol_3[$i];

            $jumlah_pria_gol_2[$i] = $pria8[$i] + $pria7[$i] + $pria6[$i] + $pria5[$i];
            $jumlah_wanita_gol_2[$i] = $wanita8[$i] + $wanita7[$i] + $wanita6[$i] + $wanita5[$i];
            $total_semua_gol_2[$i] = $jumlah_pria_gol_2[$i] + $jumlah_wanita_gol_2[$i];

            $jumlah_pria_gol_1[$i] = $pria4[$i] + $pria3[$i] + $pria2[$i] + $pria1[$i];
            $jumlah_wanita_gol_1[$i] = $wanita4[$i] + $wanita3[$i] + $wanita2[$i] + $wanita1[$i];
            $total_semua_gol_1[$i] = $jumlah_pria_gol_1[$i] + $jumlah_wanita_gol_1[$i];

            $i++;
        }
        
        $jumlah_gol_4 =  Pegawai::
                        where('status_hapus',0)                
                        ->where(function ($query) {
                            $query->where('golongan', 'Golongan IV/e')
                                ->orWhere('golongan', 'Golongan IV/d')
                                ->orWhere('golongan', 'Golongan IV/c')
                                ->orWhere('golongan', 'Golongan IV/b')
                                ->orWhere('golongan', 'Golongan IV/a');
                        })
                        ->count();

        $jumlah_gol_3 =  Pegawai::
                        where('status_hapus',0)       
                        ->where(function ($query) {
                            $query->where('golongan', 'Golongan III/d')
                                ->orWhere('golongan', 'Golongan III/c')
                                ->orWhere('golongan', 'Golongan III/b')
                                ->orWhere('golongan', 'Golongan III/a');
                        })
                        ->count();

        $jumlah_gol_2 =  Pegawai::
                        where('status_hapus',0)       
                        ->where(function ($query) {
                            $query->where('golongan', 'Golongan II/d')
                                ->orWhere('golongan', 'Golongan II/c')
                                ->orWhere('golongan', 'Golongan II/b')
                                ->orWhere('golongan', 'Golongan II/a');
                        })
                        ->count();

        $jumlah_gol_1 =  Pegawai::
                        where('status_hapus',0)       
                        ->where(function ($query) {
                            $query->where('golongan', 'Golongan I/d')
                                ->orWhere('golongan', 'Golongan I/c')
                                ->orWhere('golongan', 'Golongan I/b')
                                ->orWhere('golongan', 'Golongan I/a');
                        })
                        ->count();

        return view('admin.rekapitulasi.golongan',compact(
            'bidang',
            'jumlah_pegawai_bidang',
            'pria',
            'wanita',
            'pria17',
            'pria16',
            'pria15',
            'pria14',
            'pria13',
            'pria12',
            'pria11',
            'pria10',
            'pria9',
            'pria8',
            'pria7',
            'pria6',
            'pria5',
            'pria4',
            'pria3',
            'pria2',
            'pria1',
            'wanita17',
            'wanita16',
            'wanita15',
            'wanita14',
            'wanita13',
            'wanita12',
            'wanita11',
            'wanita10',
            'wanita9',
            'wanita8',
            'wanita7',
            'wanita6',
            'wanita5',
            'wanita4',
            'wanita3',
            'wanita2',
            'wanita1','total17','total16','total15',
            'total14',
            'total13',
            'total12',
            'total11',
            'total10',
            'total9',
            'total8',
            'total7',
            'total6',
            'total5',
            'total4',
            'total3',
            'total2',
            'total1',
            'jumlah_pria_gol_4',
            'jumlah_wanita_gol_4',
            'total_semua_gol_4',
            'jumlah_pria_gol_3',
            'jumlah_wanita_gol_3',
            'total_semua_gol_3',
            'jumlah_pria_gol_2',
            'jumlah_wanita_gol_2',
            'total_semua_gol_2',
            'jumlah_pria_gol_1',
            'jumlah_wanita_gol_1',
            'total_semua_gol_1',
            'jumlah_gol_4',
            'jumlah_gol_3',
            'jumlah_gol_2',
            'jumlah_gol_1',
        ));
    }

    public function rekapitulasi_asn_aktif()
    {
        $pria = Pegawai::where('jenis_kelamin','Pria')->where('status_hapus',0)->count();
        $wanita = Pegawai::where('jenis_kelamin','Wanita')->where('status_hapus',0)->count();
        return view('admin.rekapitulasi.asn_aktif',compact('pria','wanita'));
    }
    
    public function rekapitulasi_asn_non_aktif()
    {
        $pria = Pegawai::where('jenis_kelamin','Pria')->where('status_hapus','>',0)->count();
        $wanita = Pegawai::where('jenis_kelamin','Wanita')->where('status_hapus','>',0)->count();
        $asn_non_aktif = Pegawai::where('status_hapus',">",0)->get();
        return view('admin.rekapitulasi.asn_non_aktif',compact('pria','wanita','asn_non_aktif'));
    }
    
    public function rekapitulasi_cuti()
    {
        $pria = RiwayatCuti::
                leftJoin('pegawai_tbl', 'riwayat_cuti_tbl.Pegawai_id', '=', 'pegawai_tbl.id')
                ->where(function ($query) {
                    $query->where('mulai', '<=', date('Y-m-d'))
                        ->orWhere('selesai', '>=', date('Y-m-d'));
                })
                ->where('jenis_kelamin','Pria')
                ->where('status_hapus',0)
                ->groupBy('pegawai_id')
                ->count();
        $wanita = RiwayatCuti::
                leftJoin('pegawai_tbl', 'riwayat_cuti_tbl.Pegawai_id', '=', 'pegawai_tbl.id')
                ->where(function ($query) {
                    $query->where('mulai', '<=', date('Y-m-d'))
                        ->orWhere('selesai', '>=', date('Y-m-d'));
                })
                ->where('jenis_kelamin','Wanita')
                ->where('status_hapus',0)
                ->groupBy('pegawai_id')
                ->count();
        return view('admin.rekapitulasi.cuti',compact('pria','wanita'));
    }
    
    public function rekapitulasi_pensiunan()
    {
        $pria = Pegawai::where('jenis_kelamin','Pria')->where('status_hapus',2)->count();
        $wanita = Pegawai::where('jenis_kelamin','Wanita')->where('status_hapus',2)->count();
        return view('admin.rekapitulasi.pensiunan',compact('pria','wanita'));
    }

    public function rekapitulasi_pendidikan()
    {
        $pendidikan1 = Pegawai::where('pendidikan','SD')->where('status_hapus',0)->count();
        $pendidikan2 = Pegawai::where('pendidikan','SLTP')->where('status_hapus',0)->count();
        $pendidikan3 = Pegawai::where('pendidikan','SLTP Kejuruan')->where('status_hapus',0)->count();
        $pendidikan4 = Pegawai::where('pendidikan','SLTA')->where('status_hapus',0)->count();
        $pendidikan5 = Pegawai::where('pendidikan','SLTA Kejuruan')->where('status_hapus',0)->count();
        $pendidikan6 = Pegawai::where('pendidikan','SLTA Keguruan')->where('status_hapus',0)->count();
        $pendidikan7 = Pegawai::where('pendidikan','Diploma I')->where('status_hapus',0)->count();
        $pendidikan8 = Pegawai::where('pendidikan','Diploma II')->where('status_hapus',0)->count();
        $pendidikan9 = Pegawai::where('pendidikan','Diploma III / Sarjana Muda')->where('status_hapus',0)->count();
        $pendidikan10 = Pegawai::where('pendidikan','Diploma IV')->where('status_hapus',0)->count();
        $pendidikan11 = Pegawai::where('pendidikan','S1 / Sarjana')->where('status_hapus',0)->count();
        $pendidikan12 = Pegawai::where('pendidikan','S2')->where('status_hapus',0)->count();
        $pendidikan13 = Pegawai::where('pendidikan','S3 / Doktor')->where('status_hapus',0)->count();
        $jumlah = $pendidikan1+$pendidikan2+$pendidikan3+$pendidikan4+$pendidikan5+$pendidikan6+$pendidikan7+$pendidikan8+$pendidikan9+$pendidikan10+$pendidikan11+$pendidikan12;
        return view('admin.rekapitulasi.pendidikan',compact(
            'pendidikan1',
            'pendidikan2',
            'pendidikan3',
            'pendidikan4',
            'pendidikan5',
            'pendidikan6',
            'pendidikan7',
            'pendidikan8',
            'pendidikan9',
            'pendidikan10',
            'pendidikan11',
            'pendidikan12',
            'pendidikan13',
            'jumlah',
        ));
    }
}
