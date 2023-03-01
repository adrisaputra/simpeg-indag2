<?php

namespace App\Http\Controllers;

use App\Models\PengumumanDiklatPim;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengumumanDiklatPimController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pengumuman Diklat PIM IV,III,II";
		$pengumuman_diklat_pim = DB::table('pengumuman_diklat_pim_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_diklat_pim.index',compact('title','pengumuman_diklat_pim'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pengumuman Diklat PIM IV,III,II";
        $pengumuman_diklat_pim = $request->get('search');
		$pengumuman_diklat_pim = PengumumanDiklatPim::
                where(function ($query) use ($pengumuman_diklat_pim) {
                    $query->where('judul', 'LIKE', '%'.$pengumuman_diklat_pim.'%')
                        ->orWhere('penyelenggara', 'LIKE', '%'.$pengumuman_diklat_pim.'%')
                        ->orWhere('bidang', 'LIKE', '%'.$pengumuman_diklat_pim.'%')
                        ->orWhere('syarat', 'LIKE', '%'.$pengumuman_diklat_pim.'%')
                        ->orWhere('tanggal_mulai', 'LIKE', '%'.$pengumuman_diklat_pim.'%')
                        ->orWhere('tanggal_selesai', 'LIKE', '%'.$pengumuman_diklat_pim.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.pengumuman_diklat_pim.index',compact('title','pengumuman_diklat_pim'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pengumuman Diklat PIM IV,III,II";
        $view=view('admin.pengumuman_diklat_pim.create', compact('title'));
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

        PengumumanDiklatPim::create($input);
		
		return redirect('/pengumuman_diklat_pim')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(PengumumanDiklatPim $pengumuman_diklat_pim)
    {
        $title = "Pengumuman Diklat PIM IV,III,II";
        $view=view('admin.pengumuman_diklat_pim.edit', compact('title','pengumuman_diklat_pim'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, PengumumanDiklatPim $pengumuman_diklat_pim)
    {
		$this->validate($request, [
            'judul' => 'required',
            'penyelenggara' => 'required',
            'bidang' => 'required',
            'syarat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
		]);
		
        $pengumuman_diklat_pim->fill($request->all());
        $pengumuman_diklat_pim->user_id = Auth::user()->id;
        $pengumuman_diklat_pim->save();
    
		return redirect('/pengumuman_diklat_pim')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PengumumanDiklatPim $pengumuman_diklat_pim)
    {
		$pengumuman_diklat_pim->delete();
		
		return redirect('/pengumuman_diklat_pim')->with('status', 'Data Berhasil Dihapus');
    }
}
