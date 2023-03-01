<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;   //nama model
use App\Models\Honorer;   //nama model
use App\Models\Absen;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('status_hapus', 0)->count();
            $honorer = Honorer::count();
            $pensiun = Pegawai::select('*', DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur'), DB::raw("tanggal_lahir + INTERVAL '58' YEAR AS pensiun"))
                        ->where('status_hapus', 0)
                        ->whereRaw('YEAR(tanggal_lahir) = YEAR(DATE_SUB(CURDATE(), INTERVAL 58 YEAR))')
                        ->count();
            $kgb = Pegawai::where('status_hapus', 0)
                        ->whereRaw('YEAR(kgb_saat_ini) = YEAR(DATE_SUB(CURDATE(), INTERVAL 2 YEAR))')
                        ->count();
            $kehadiran = Absen::where('tanggal', date('Y-m-d'))->where('kehadiran', 'H')->count();
            $naik_pangkat = Pegawai::where('status_hapus', 0)
                      ->whereRaw('YEAR(tmt) = YEAR(DATE_SUB(CURDATE(), INTERVAL 4 YEAR))')
                      ->count();
            return view('admin.beranda', compact('pegawai','honorer','pensiun','kgb','kehadiran','naik_pangkat'));
        } else if(Auth::user()->group==3){
            $count = Absen::where('nip', Auth::user()->name)->where('tanggal', date('Y-m-d'))->count();
            $status_kehadiran = Absen::where('nip', Auth::user()->name)->where('tanggal', date('Y-m-d'))->get();
            return view('admin.beranda', compact('count','status_kehadiran'));
        }
        
    }
}
