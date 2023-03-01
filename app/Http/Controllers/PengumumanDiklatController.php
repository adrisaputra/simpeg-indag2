<?php

namespace App\Http\Controllers;

use App\Models\PengumumanDiklat;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengumumanDiklatController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pengumuman Diklat Teknis";
		$pengumuman_diklat = DB::table('pengumuman_diklat_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_diklat.index',compact('title','pengumuman_diklat'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pengumuman Diklat Teknis";
        $pengumuman_diklat = $request->get('search');
		$pengumuman_diklat = PengumumanDiklat::
                where(function ($query) use ($pengumuman_diklat) {
                    $query->where('judul', 'LIKE', '%'.$pengumuman_diklat.'%')
                        ->orWhere('penyelenggara', 'LIKE', '%'.$pengumuman_diklat.'%')
                        ->orWhere('bidang', 'LIKE', '%'.$pengumuman_diklat.'%')
                        ->orWhere('syarat', 'LIKE', '%'.$pengumuman_diklat.'%')
                        ->orWhere('tanggal_mulai', 'LIKE', '%'.$pengumuman_diklat.'%')
                        ->orWhere('tanggal_selesai', 'LIKE', '%'.$pengumuman_diklat.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_diklat.index',compact('title','pengumuman_diklat'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pengumuman Diklat Teknis";
        $view=view('admin.pengumuman_diklat.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'judul' => 'required',
            'penyelenggara' => 'required',
            'bidang' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $input['judul'] = $request->judul;
        $input['penyelenggara'] = $request->penyelenggara;
        $input['bidang'] = $request->bidang;
        $input['syarat'] = $request->syarat;
        $input['tanggal_mulai'] = $request->tanggal_mulai;
        $input['tanggal_selesai'] = $request->tanggal_selesai;
        $input['user_id'] = Auth::user()->id;

        PengumumanDiklat::create($input);
		
		return redirect('/pengumuman_diklat')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengumumanDiklat $pengumuman_diklat)
    {
        $title = "Pengumuman Diklat Teknis";
        $view=view('admin.pengumuman_diklat.edit', compact('title','pengumuman_diklat'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengumumanDiklat $pengumuman_diklat)
    {
		$this->validate($request, [
            'judul' => 'required',
            'penyelenggara' => 'required',
            'bidang' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $pengumuman_diklat->fill($request->all());
        $pengumuman_diklat->user_id = Auth::user()->id;
        $pengumuman_diklat->save();
    
		return redirect('/pengumuman_diklat')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengumumanDiklat $pengumuman_diklat)
    {
		$pengumuman_diklat->delete();
		
		return redirect('/pengumuman_diklat')->with('status', 'Data Berhasil Dihapus');
    }
}