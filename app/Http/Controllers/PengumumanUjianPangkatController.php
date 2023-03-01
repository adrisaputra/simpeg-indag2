<?php

namespace App\Http\Controllers;

use App\Models\PengumumanUjianPangkat;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengumumanUjianPangkatController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pengumuman Ujian Kenaikan Pangkat";
		$pengumuman_ujian_pangkat = DB::table('pengumuman_ujian_pangkat_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_ujian_pangkat.index',compact('title','pengumuman_ujian_pangkat'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pengumuman Ujian Kenaikan Pangkat";
        $pengumuman_ujian_pangkat = $request->get('search');
		$pengumuman_ujian_pangkat = PengumumanUjianPangkat::
                where(function ($query) use ($pengumuman_ujian_pangkat) {
                    $query->where('lokasi', 'LIKE', '%'.$pengumuman_ujian_pangkat.'%')
                        ->orWhere('syarat', 'LIKE', '%'.$pengumuman_ujian_pangkat.'%')
                        ->orWhere('tanggal_mulai', 'LIKE', '%'.$pengumuman_ujian_pangkat.'%')
                        ->orWhere('tanggal_selesai', 'LIKE', '%'.$pengumuman_ujian_pangkat.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_ujian_pangkat.index',compact('title','pengumuman_ujian_pangkat'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pengumuman Ujian Kenaikan Pangkat";
        $view=view('admin.pengumuman_ujian_pangkat.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'lokasi' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $input['lokasi'] = $request->lokasi;
        $input['syarat'] = $request->syarat;
        $input['tanggal_mulai'] = $request->tanggal_mulai;
        $input['tanggal_selesai'] = $request->tanggal_selesai;
        $input['user_id'] = Auth::user()->id;

        PengumumanUjianPangkat::create($input);
		
		return redirect('/pengumuman_ujian_pangkat')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengumumanUjianPangkat $pengumuman_ujian_pangkat)
    {
        $title = "Pengumuman Ujian Kenaikan Pangkat";
        $view=view('admin.pengumuman_ujian_pangkat.edit', compact('title','pengumuman_ujian_pangkat'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengumumanUjianPangkat $pengumuman_ujian_pangkat)
    {
		$this->validate($request, [
            'lokasi' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $pengumuman_ujian_pangkat->fill($request->all());
        $pengumuman_ujian_pangkat->user_id = Auth::user()->id;
        $pengumuman_ujian_pangkat->save();
    
		return redirect('/pengumuman_ujian_pangkat')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengumumanUjianPangkat $pengumuman_ujian_pangkat)
    {
		$pengumuman_ujian_pangkat->delete();
		
		return redirect('/pengumuman_ujian_pangkat')->with('status', 'Data Berhasil Dihapus');
    }
}
