<?php

namespace App\Http\Controllers;

use App\Models\PengumumanUjianDinas;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengumumanUjianDinasController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pengumuman Ujian Dinas";
		$pengumuman_ujian_dinas = DB::table('pengumuman_ujian_dinas_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_ujian_dinas.index',compact('title','pengumuman_ujian_dinas'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pengumuman Ujian Dinas";
        $pengumuman_ujian_dinas = $request->get('search');
		$pengumuman_ujian_dinas = PengumumanUjianDinas::
                where(function ($query) use ($pengumuman_ujian_dinas) {
                    $query->where('lokasi', 'LIKE', '%'.$pengumuman_ujian_dinas.'%')
                        ->orWhere('syarat', 'LIKE', '%'.$pengumuman_ujian_dinas.'%')
                        ->orWhere('tanggal_mulai', 'LIKE', '%'.$pengumuman_ujian_dinas.'%')
                        ->orWhere('tanggal_selesai', 'LIKE', '%'.$pengumuman_ujian_dinas.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_ujian_dinas.index',compact('title','pengumuman_ujian_dinas'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pengumuman Ujian Dinas";
        $view=view('admin.pengumuman_ujian_dinas.create', compact('title'));
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

        PengumumanUjianDinas::create($input);
		
		return redirect('/pengumuman_ujian_dinas')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengumumanUjianDinas $pengumuman_ujian_dinas)
    {
        $title = "Pengumuman Ujian Dinas";
        $view=view('admin.pengumuman_ujian_dinas.edit', compact('title','pengumuman_ujian_dinas'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengumumanUjianDinas $pengumuman_ujian_dinas)
    {
		$this->validate($request, [
            'lokasi' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $pengumuman_ujian_dinas->fill($request->all());
        $pengumuman_ujian_dinas->user_id = Auth::user()->id;
        $pengumuman_ujian_dinas->save();
    
		return redirect('/pengumuman_ujian_dinas')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengumumanUjianDinas $pengumuman_ujian_dinas)
    {
		$pengumuman_ujian_dinas->delete();
		
		return redirect('/pengumuman_ujian_dinas')->with('status', 'Data Berhasil Dihapus');
    }
}
